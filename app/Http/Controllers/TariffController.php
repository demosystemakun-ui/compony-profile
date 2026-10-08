<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TariffController extends Controller
{
    private const DISK = 'supabase';

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

    /**
     * Tampilkan PDF inline dari domain sendiri (dipakai pdf.js di modal).
     * Lewat proxy ini, CORS bucket Supabase tidak perlu diatur.
     */
    public function stream(Tariff $tariff)
    {
        $this->abortUnlessAvailable($tariff);

        return Storage::disk(self::DISK)->response(
            $tariff->pdf_path,
            Str::slug($tariff->title) . '.pdf',
            [
                'Content-Type'  => 'application/pdf',
                'Cache-Control' => 'public, max-age=300',
            ],
            'inline'
        );
    }

    /** Download PDF */
    public function download(Tariff $tariff)
    {
        $this->abortUnlessAvailable($tariff);

        return Storage::disk(self::DISK)->download(
            $tariff->pdf_path,
            Str::slug($tariff->title) . '.pdf'
        );
    }

    /** Hanya tarif aktif dengan file yang benar-benar ada yang boleh diakses. */
    private function abortUnlessAvailable(Tariff $tariff): void
    {
        abort_unless($tariff->is_active && $tariff->hasPdf(), 404);
        abort_unless(Storage::disk(self::DISK)->exists($tariff->pdf_path), 404);
    }

    /* ═══════════════════════════════════════════════
        ADMIN (CRUD)
    ═══════════════════════════════════════════════ */

    public function index()
    {
        $tariffs = Tariff::orderBy('sort_order')->orderBy('id')->get();

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
        $data = $this->validated($request);

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('tariffs', self::DISK);
        }

        Tariff::create($data);

        return redirect()->route('admin.tariffs.index')
            ->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit(Tariff $tariff)
    {
        return view('admin.tariffs.form', compact('tariff'));
    }

    public function update(Request $request, Tariff $tariff)
    {
        $data    = $this->validated($request);
        $oldPath = $tariff->pdf_path;

        // 1) Upload file baru lebih dulu; jika gagal, file lama tetap aman.
        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('tariffs', self::DISK);
        } elseif ($request->boolean('remove_pdf')) {
            $data['pdf_path'] = null;
        }

        // 2) Perbarui database.
        $tariff->update($data);

        // 3) Baru hapus file lama setelah DB berhasil diperbarui.
        if (array_key_exists('pdf_path', $data) && $oldPath && $oldPath !== $data['pdf_path']) {
            $this->deleteFileSafely($oldPath);
        }

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
            'pdf'         => ['nullable', 'file', 'mimes:pdf', 'max:20480'], // 20 MB
        ]);

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        unset($data['pdf']);

        return $data;
    }

    /** Preview PDF untuk admin: boleh melihat tarif yang disembunyikan. */
public function preview(Tariff $tariff)
{
    abort_unless($tariff->hasPdf(), 404);
    abort_unless(Storage::disk(self::DISK)->exists($tariff->pdf_path), 404);

    return Storage::disk(self::DISK)->response(
        $tariff->pdf_path,
        Str::slug($tariff->title) . '.pdf',
        ['Content-Type' => 'application/pdf', 'Cache-Control' => 'private, no-store'],
        'inline'
    );
}
}
