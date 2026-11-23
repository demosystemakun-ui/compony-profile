<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TariffController extends Controller
{
    private const DISK = 'supabase-tariffs';

    /* ═══════════════════════════════════════════════
        PUBLIK
    ═══════════════════════════════════════════════ */

    /** Halaman /our-tariffs */
    public function publicIndex()
    {
        $tariffs = Tariff::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('our-tariffs', compact('tariffs'));
    }

    /** PDF inline untuk modal pdf.js (hanya tarif aktif). */
    public function stream(Tariff $tariff)
    {
        $this->abortUnlessAvailable($tariff);

        return $this->pdfResponse($tariff);
    }

    /** Download PDF (hanya tarif aktif). */
    public function download(Tariff $tariff)
    {
        $this->abortUnlessAvailable($tariff);

        return Storage::disk(self::DISK)->download(
            $tariff->pdf_path,
            Str::slug($tariff->title) . '.pdf'
        );
    }

    /** Hanya tarif aktif dengan file yang benar-benar ada yang boleh diakses publik. */
    private function abortUnlessAvailable(Tariff $tariff): void
    {
        abort_unless($tariff->is_active && $tariff->hasPdf(), 404);
        abort_unless(Storage::disk(self::DISK)->exists($tariff->pdf_path), 404);
    }

    private function pdfResponse(Tariff $tariff, string $cache = 'public, max-age=300')
    {
        return Storage::disk(self::DISK)->response(
            $tariff->pdf_path,
            Str::slug($tariff->title) . '.pdf',
            ['Content-Type' => 'application/pdf', 'Cache-Control' => $cache],
            'inline'
        );
    }

    /* ═══════════════════════════════════════════════
        ADMIN (CRUD)
    ═══════════════════════════════════════════════ */

    /** Preview PDF untuk admin: boleh melihat tarif yang disembunyikan. */
    public function preview(Tariff $tariff)
    {
        abort_unless($tariff->hasPdf(), 404);
        abort_unless(Storage::disk(self::DISK)->exists($tariff->pdf_path), 404);

        return $this->pdfResponse($tariff, 'private, no-store');
    }

    /**
     * Menampilkan daftar tarif dengan fitur Pencarian & Filter Otomatis.
     */
    public function index(Request $request)
    {
        // 1. Mulai Query
        $query = Tariff::query();

        // 2. Logika Pencarian (Search)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 3. Logika Filter Kategori (Tag)
        if ($request->filled('tag')) {
            $query->where('tag', $request->tag);
        }

        // 4. Logika Filter Status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // 5. Eksekusi Query
        $tariffs = $query->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.tariffs.index', compact('tariffs'));
    }

    public function create()
    {
        return view('admin.tariffs.form', [
            'tariff' => new Tariff(['icon' => 'document', 'is_active' => true]),
        ]);
    }

    public function store(Request $request)
    {
        // PDF WAJIB saat create + maksimal 10 MB
        $request->validate([
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'pdf.required' => 'File PDF wajib diunggah.',
            'pdf.file'     => 'File PDF tidak valid.',
            'pdf.mimes'    => 'File harus berformat PDF.',
            'pdf.max'      => 'Ukuran PDF maksimal 10 MB.',
        ]);

        $data = $this->validated($request);

        $data['pdf_path'] = $request->file('pdf')->store('tariffs', self::DISK);

        Tariff::create($data);

        Cache::forget(DashboardController::STATS_CACHE_KEY);

        return redirect()->route('admin.tariffs.index')
            ->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit(Tariff $tariff)
    {
        return view('admin.tariffs.form', compact('tariff'));
    }

    public function update(Request $request, Tariff $tariff)
    {
        // PDF wajib jika:
        // - belum punya file, ATAU
        // - admin mencentang "Delete PDF" (remove_pdf)
        $hasExisting = $tariff->hasPdf() && !$request->boolean('remove_pdf');

        $request->validate([
            'pdf' => [
                $hasExisting ? 'nullable' : 'required',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ], [
            'pdf.required' => 'File PDF wajib diunggah.',
            'pdf.file'     => 'File PDF tidak valid.',
            'pdf.mimes'    => 'File harus berformat PDF.',
            'pdf.max'      => 'Ukuran PDF maksimal 10 MB.',
        ]);

        $data    = $this->validated($request);
        $oldPath = $tariff->pdf_path;

        // 1) Upload file baru lebih dulu; jika gagal, file lama tetap aman.
        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('tariffs', self::DISK);
        } elseif ($request->boolean('remove_pdf')) {
            // Karena validasi di atas mewajibkan upload saat remove_pdf,
            // cabang ini hanya tercapai bila hasExisting === true namun user
            // tidak mencentang remove_pdf (tidak mungkin), jadi aman.
            $data['pdf_path'] = null;
        }

        // 2) Perbarui database.
        $tariff->update($data);

        // 3) Baru hapus file lama setelah DB berhasil diperbarui.
        if (array_key_exists('pdf_path', $data) && $oldPath && $oldPath !== $data['pdf_path']) {
            $this->deleteFileSafely($oldPath);
        }

        Cache::forget(DashboardController::STATS_CACHE_KEY);

        return redirect()->route('admin.tariffs.index')
            ->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Tariff $tariff)
    {
        $path = $tariff->pdf_path;

        $tariff->delete();

        if ($path) {
            $this->deleteFileSafely($path);
        }

        Cache::forget(DashboardController::STATS_CACHE_KEY);

        return redirect()->route('admin.tariffs.index')
            ->with('success', 'Tarif berhasil dihapus.');
    }

    /** Hapus file di Supabase tanpa menggagalkan request jika storage tidak terjangkau. */
    private function deleteFileSafely(string $path): void
    {
        try {
            Storage::disk(self::DISK)->delete($path);
        } catch (\Throwable $e) {
            Log::warning('Gagal menghapus PDF tarif dari Supabase.', [
                'path'  => $path,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'tag'         => ['required', Rule::in(Tariff::TAGS)],
            'title'       => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:300'],
            'icon'        => ['required', Rule::in(array_keys(Tariff::ICONS))],
            'sort_order'  => ['nullable', 'integer', 'min:0', 'max:999'],
            'pdf'         => ['nullable', 'file', 'mimes:pdf', 'max:10240'], // 10 MB
        ]);

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['updated_by'] = auth()->id();
        unset($data['pdf']);

        return $data;
    }
}