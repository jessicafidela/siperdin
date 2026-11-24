<?php

namespace App\Http\Controllers;

use App\Models\TemplateDokumen;
use Illuminate\Http\Request;

class TemplateDokumenController extends Controller
{
    // Menampilkan seluruh template dokumen
    public function index()
    {
        $templateDokumens = TemplateDokumen::orderByDesc('id_template')
            ->get();

        return view(
            'template-dokumen.index',
            compact('templateDokumens')
        );
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('template-dokumen.create');
    }

    // Menyimpan template baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_template' => 'required|string|max:100',
            'jenis_dokumen' => 'required|string|max:50',
            'format_file' => 'nullable|string|max:20',
            'struktur_dokumen' => 'nullable|string',
            'aturan_penomoran' => 'nullable|string',
            'lokasi_template' => 'nullable|string|max:255',
        ]);

        TemplateDokumen::create($validated);

        return redirect()
            ->route('template-dokumen.index')
            ->with('success', 'Template dokumen berhasil ditambahkan.');
    }

    // Menampilkan detail template
    public function show(TemplateDokumen $templateDokumen)
    {
        return view(
            'template-dokumen.show',
            compact('templateDokumen')
        );
    }

    // Menampilkan form edit
    public function edit(TemplateDokumen $templateDokumen)
    {
        return view(
            'template-dokumen.edit',
            compact('templateDokumen')
        );
    }

    // Memperbarui template
    public function update(
        Request $request,
        TemplateDokumen $templateDokumen
    ) {
        $validated = $request->validate([
            'nama_template' => 'required|string|max:100',
            'jenis_dokumen' => 'required|string|max:50',
            'format_file' => 'nullable|string|max:20',
            'struktur_dokumen' => 'nullable|string',
            'aturan_penomoran' => 'nullable|string',
            'lokasi_template' => 'nullable|string|max:255',
        ]);

        $templateDokumen->update($validated);

        return redirect()
            ->route('template-dokumen.index')
            ->with('success', 'Template dokumen berhasil diperbarui.');
    }

    // Menghapus template
    public function destroy(TemplateDokumen $templateDokumen)
    {
        $templateDokumen->delete();

        return redirect()
            ->route('template-dokumen.index')
            ->with('success', 'Template dokumen berhasil dihapus.');
    }
}
