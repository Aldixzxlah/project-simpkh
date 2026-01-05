<?php

namespace App\Http\Controllers;

use App\Models\DataHutan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forests = DataHutan::latest()->paginate(10);
        return view('admin.forests.index', compact('forests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.forests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'provinsi' => 'required|string|max:100',
            'pulau' => 'nullable|string|max:50',
            'luas_hektar' => 'required|numeric|min:0',
            'jenis_vegetasi' => 'nullable|array',
            'status_konservasi' => 'required|in:konservasi,lindung,produksi,konversi',
            'geojson' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $validated['updated_by'] = Auth::id();

        DataHutan::create($validated);

        return redirect()->route('admin.forests.index')->with('success', 'Data hutan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataHutan $forest)
    {
        return view('admin.forests.edit', compact('forest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataHutan $forest)
    {
        $validated = $request->validate([
            'provinsi' => 'required|string|max:100',
            'pulau' => 'nullable|string|max:50',
            'luas_hektar' => 'required|numeric|min:0',
            'jenis_vegetasi' => 'nullable|array',
            'status_konservasi' => 'required|in:konservasi,lindung,produksi,konversi',
            'geojson' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $validated['updated_by'] = Auth::id();

        $forest->update($validated);

        return redirect()->route('admin.forests.index')->with('success', 'Data hutan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataHutan $forest)
    {
        $forest->delete();

        return redirect()->route('admin.forests.index')->with('success', 'Data hutan berhasil dihapus.');
    }
}
