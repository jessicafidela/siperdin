<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Satker;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawais = Pegawai::with('satker')->latest()->get();

        return view('pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satkers = Satker::all();

        return view('pegawai.create', compact('satkers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'satker_id' => ['required', 'exists:satkers,id'],
            'nip' => ['required', 'unique:pegawais,nip'],
            'nama_pegawai' => ['required'],
            'jabatan' => ['required'],
            'golongan' => ['required'],
        ]);

        Pegawai::create($validated);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data Pegawai berhasil ditambahkan.');
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
    public function edit(Pegawai $pegawai)
    {
        $satkers = Satker::all();

        return view('pegawai.edit', compact('pegawai', 'satkers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'satker_id' => ['required', 'exists:satkers,id'],
            'nip' => ['required', 'unique:pegawais,nip,'.$pegawai->id],
            'nama_pegawai' => ['required'],
            'jabatan' => ['required'],
            'golongan' => ['required'],
        ]);

        $pegawai->update($validated);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data Pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data Pegawai berhasil dihapus.');
    }
}
