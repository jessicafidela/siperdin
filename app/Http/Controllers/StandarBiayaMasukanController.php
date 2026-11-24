<?php

namespace App\Http\Controllers;

use App\Models\StandarBiayaMasukan;
use Illuminate\Http\Request;

class StandarBiayaMasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sbms = StandarBiayaMasukan::query()
            ->orderByDesc('id_sbm')
            ->get();

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
            'tahun_berlaku' => [
                'required',
                'integer',
                'digits:4',
                'between:1901,2155',
            ],
            'jenis_biaya' => [
                'required',
                'string',
                'max:50',
            ],
            'gol_ruang' => [
                'nullable',
                'string',
                'max:20',
            ],
            'lokasi' => [
                'nullable',
                'string',
                'max:100',
            ],
            'nilai_biaya' => [
                'required',
                'numeric',
                'min:0',
            ],
            'keterangan' => [
                'nullable',
                'string',
            ],
        ]);

        StandarBiayaMasukan::create($validated);

        return redirect()
            ->route('standar-biaya-masukan.index')
            ->with(
                'success',
                'Data Standar Biaya Masukan berhasil ditambahkan.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(StandarBiayaMasukan $standarBiayaMasukan)
    {
        return view(
            'sbm.show',
            compact('standarBiayaMasukan')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StandarBiayaMasukan $standarBiayaMasukan)
    {
        return view(
            'sbm.edit',
            compact('standarBiayaMasukan')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        StandarBiayaMasukan $standarBiayaMasukan
    ) {
        $validated = $request->validate([
            'tahun_berlaku' => [
                'required',
                'integer',
                'digits:4',
                'between:1901,2155',
            ],
            'jenis_biaya' => [
                'required',
                'string',
                'max:50',
            ],
            'gol_ruang' => [
                'nullable',
                'string',
                'max:20',
            ],
            'lokasi' => [
                'nullable',
                'string',
                'max:100',
            ],
            'nilai_biaya' => [
                'required',
                'numeric',
                'min:0',
            ],
            'keterangan' => [
                'nullable',
                'string',
            ],
        ]);

        $standarBiayaMasukan->update($validated);

        return redirect()
            ->route('standar-biaya-masukan.index')
            ->with(
                'success',
                'Data Standar Biaya Masukan berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        StandarBiayaMasukan $standarBiayaMasukan
    ) {
        $standarBiayaMasukan->delete();

        return redirect()
            ->route('standar-biaya-masukan.index')
            ->with(
                'success',
                'Data Standar Biaya Masukan berhasil dihapus.'
            );
    }
}
