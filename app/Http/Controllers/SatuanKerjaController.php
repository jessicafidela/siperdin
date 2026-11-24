<?php

namespace App\Http\Controllers;

use App\Models\SatuanKerja;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SatuanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $satuanKerjas = SatuanKerja::latest()->get();

        return view('satker.index', compact('satuanKerjas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('satker.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_satker' => [
                'required',
                'string',
                Rule::unique('satuan_kerja', 'kode_satker'),
            ],

            'nama_satker' => [
                'required',
                'string',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                Rule::in(['aktif', 'nonaktif']),
            ],
        ]);

        SatuanKerja::create($validated);

        return redirect()
            ->route('satuan-kerja.index')
            ->with('success', 'Data Satuan Kerja berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SatuanKerja $satuanKerja)
    {
        return view('satker.show', compact('satuanKerja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SatuanKerja $satuanKerja)
    {
        return view('satker.edit', compact('satuanKerja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SatuanKerja $satuanKerja)
    {
        $validated = $request->validate([
            'kode_satker' => [
                'required',
                'string',
                Rule::unique('satuan_kerja', 'kode_satker')
                    ->ignore($satuanKerja->id_satker, 'id_satker'),
            ],

            'nama_satker' => [
                'required',
                'string',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                Rule::in(['aktif', 'nonaktif']),
            ],
        ]);

        $satuanKerja->update($validated);

        return redirect()
            ->route('satuan-kerja.index')
            ->with('success', 'Data Satuan Kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SatuanKerja $satuanKerja)
    {
        $satuanKerja->delete();

        return redirect()
            ->route('satuan-kerja.index')
            ->with('success', 'Data Satuan Kerja berhasil dihapus.');
    }
}
