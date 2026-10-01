<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TariffController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.tariffs.index', compact('tariffs'));
    }

    public function create()
    {
        return view('admin.tariffs.form', ['tariff' => new Tariff(['icon' => 'document', 'is_active' => true])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('tariffs', 'public');
        }

        Tariff::create($data);

        return redirect()->route('admin.tariffs.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit(Tariff $tariff)
    {
        return view('admin.tariffs.form', compact('tariff'));
    }

    public function update(Request $request, Tariff $tariff)
    {
        $data = $this->validated($request);

        if ($request->hasFile('pdf')) {
            $tariff->deletePdfFile();                                  // hapus file lama
            $data['pdf_path'] = $request->file('pdf')->store('tariffs', 'public');
        } elseif ($request->boolean('remove_pdf')) {
            $tariff->deletePdfFile();
            $data['pdf_path'] = null;
        }

        $tariff->update($data);

        return redirect()->route('admin.tariffs.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Tariff $tariff)
    {
        $tariff->deletePdfFile();
        $tariff->delete();

        return redirect()->route('admin.tariffs.index')->with('success', 'Tarif berhasil dihapus.');
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
}