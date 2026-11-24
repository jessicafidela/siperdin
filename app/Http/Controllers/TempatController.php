<?php

namespace App\Http\Controllers;

use App\Models\Tempat;
use Illuminate\Http\Request;

class TempatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tempats = Tempat::orderByDesc('id_tempat')->get();

        return view(
            'tempat.index',
            compact('tempats')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tempat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'nama_tempat' => [
                'required',
                'string',
            ],

            'jenis_tempat' => [
                'nullable',
                'string',
            ],

            'wilayah' => [
                'nullable',
                'string',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:aktif,nonaktif',
            ],

        ]);

        Tempat::create($validated);

        return redirect()
            ->route('tempat.index')
            ->with(
                'success',
                'Data Tempat berhasil ditambahkan.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Tempat $tempat)
    {
        return view(
            'tempat.show',
            compact('tempat')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tempat $tempat)
    {
        return view(
            'tempat.edit',
            compact('tempat')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        Tempat $tempat
    ) {
        $validated = $request->validate([

            'nama_tempat' => [
                'required',
                'string',
            ],

            'jenis_tempat' => [
                'nullable',
                'string',
            ],

            'wilayah' => [
                'nullable',
                'string',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:aktif,nonaktif',
            ],

        ]);

        $tempat->update($validated);

        return redirect()
            ->route('tempat.index')
            ->with(
                'success',
                'Data Tempat berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tempat $tempat)
    {
        $tempat->delete();

        return redirect()
            ->route('tempat.index')
            ->with(
                'success',
                'Data Tempat berhasil dihapus.'
            );
    }
}
