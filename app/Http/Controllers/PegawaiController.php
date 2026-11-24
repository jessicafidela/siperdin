<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\SatuanKerja;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawais = Pegawai::with('satuanKerja')
            ->latest()
            ->get();

        return view(
            'pegawai.index',
            compact('pegawais')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satuanKerjas = SatuanKerja::all();

        return view(
            'pegawai.create',
            compact('satuanKerjas')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'id_satker' => [
                'required',
                'exists:satuan_kerja,id_satker',
            ],

            'nip' => [
                'required',
                'unique:pegawai,nip',
            ],

            'nip_baru' => [
                'nullable',
                'unique:pegawai,nip_baru',
            ],

            'nama_lengkap' => [
                'required',
            ],

            'pangkat' => [
                'nullable',
            ],

            'gol_ruang' => [
                'nullable',
            ],

            'tipe_jabatan' => [
                'nullable',
            ],

            'tampil_jabatan' => [
                'nullable',
            ],

            'keterangan' => [
                'nullable',
            ],

        ]);

        Pegawai::create($validated);

        return redirect()
            ->route('pegawai.index')
            ->with(
                'success',
                'Data Pegawai berhasil ditambahkan.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        $pegawai->load('satuanKerja');

        return view(
            'pegawai.show',
            compact('pegawai')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $satuanKerjas = SatuanKerja::all();

        return view(
            'pegawai.edit',
            compact(
                'pegawai',
                'satuanKerjas'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        Pegawai $pegawai
    ) {

        $validated = $request->validate([

            'id_satker' => [
                'required',
                'exists:satuan_kerja,id_satker',
            ],

            'nip' => [
                'required',
                'unique:pegawai,nip,'.$pegawai->id_pegawai.',id_pegawai',
            ],

            'nip_baru' => [
                'nullable',
                'unique:pegawai,nip_baru,'.$pegawai->id_pegawai.',id_pegawai',
            ],

            'nama_lengkap' => [
                'required',
            ],

            'pangkat' => [
                'nullable',
            ],

            'gol_ruang' => [
                'nullable',
            ],

            'tipe_jabatan' => [
                'nullable',
            ],

            'tampil_jabatan' => [
                'nullable',
            ],

            'keterangan' => [
                'nullable',
            ],

        ]);

        $pegawai->update($validated);

        return redirect()
            ->route('pegawai.index')
            ->with(
                'success',
                'Data Pegawai berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()
            ->route('pegawai.index')
            ->with(
                'success',
                'Data Pegawai berhasil dihapus.'
            );
    }
}
