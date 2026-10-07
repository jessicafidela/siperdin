<?php

namespace App\Http\Controllers;

use App\Models\Satker;
use Illuminate\Http\Request;

class SatkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $satkers = Satker::latest()->get();

        return view('satker.index', compact('satkers'));
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
                'unique:satkers,kode_satker',
            ],
            'nama_satker' => [
                'required',
            ],
        ]);

        Satker::create($validated);

        return redirect()
            ->route('satker.index')
            ->with('success', 'Data Satker berhasil ditambahkan.');
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
    public function edit(Satker $satker)
    {
        return view('satker.edit', compact('satker'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Satker $satker)
    {
        $validated = $request->validate([
            'kode_satker' => [
                'required',
                'unique:satkers,kode_satker,'.$satker->id,
            ],
            'nama_satker' => [
                'required',
            ],
        ]);

        $satker->update($validated);

        return redirect()
            ->route('satker.index')
            ->with('success', 'Data Satker berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satker $satker)
    {
        $satker->delete();

        return redirect()
            ->route('satker.index')
            ->with('success', 'Data Satker berhasil dihapus.');
    }
}
