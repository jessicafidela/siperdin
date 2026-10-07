<?php

namespace App\Http\Controllers;

use App\Models\Sbm;
use Illuminate\Http\Request;

class SbmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sbms = Sbm::latest()->get();

        return view('sbm.index', compact('sbms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sbm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_sbm' => ['required', 'unique:sbms,kode_sbm'],
            'kategori' => ['required'],
            'nama_biaya' => ['required'],
            'satuan' => ['required'],
            'nilai' => ['required', 'numeric'],
            'jenis_batas' => ['required'],
            'tahun_anggaran' => ['required'],
        ]);

        Sbm::create($validated);

        return redirect()
            ->route('sbm.index')
            ->with('success', 'Data SBM berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sbm $sbm)
    {
        return view('sbm.edit', compact('sbm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sbm $sbm)
    {
        $validated = $request->validate([
            'kode_sbm' => ['required', 'unique:sbms,kode_sbm,'.$sbm->id],
            'kategori' => ['required'],
            'nama_biaya' => ['required'],
            'satuan' => ['required'],
            'nilai' => ['required', 'numeric'],
            'jenis_batas' => ['required'],
            'tahun_anggaran' => ['required'],
        ]);

        $sbm->update($validated);

        return redirect()
            ->route('sbm.index')
            ->with('success', 'Data SBM berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sbm $sbm)
    {
        $sbm->update([
            'status' => 'tidak_aktif',
        ]);

        return redirect()
            ->route('sbm.index')
            ->with('success', 'SBM berhasil dinonaktifkan.');
    }
}
