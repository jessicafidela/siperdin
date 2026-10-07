<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::latest()->get();

        return view('place.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('place.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tempat' => ['required'],
            'provinsi' => ['required'],
        ]);

        Place::create($validated);

        return redirect()
            ->route('place.index')
            ->with('success', 'Data Tempat berhasil ditambahkan.');
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
    public function edit(Place $place)
    {
        return view('place.edit', compact('place'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
        $validated = $request->validate([
            'nama_tempat' => ['required'],
            'provinsi' => ['required'],
        ]);

        $place->update($validated);

        return redirect()
            ->route('place.index')
            ->with('success', 'Data Tempat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        $place->delete();

        return redirect()
            ->route('place.index')
            ->with('success', 'Data Tempat berhasil dihapus.');
    }
}
