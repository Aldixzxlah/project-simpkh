<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Auth::user()->laporans()->latest()->paginate(10);
        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get forests that are 'produksi' (usable by users)
        $forests = \App\Models\DataHutan::where('status_konservasi', 'produksi')->get();
        return view('reports.create', compact('forests'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate all steps
        $validated = $request->validate([
            // Step 1: Lokasi
            'lokasi_polygon' => 'required|json', // GeoJSON string
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'luas_dimohon' => 'required|numeric|min:0',

            // Step 2: Perusahaan
            'company_name' => 'required|string|max:255',
            'npwp' => 'required|string|max:50', // Store in documents
            'address' => 'required|string',

            // Step 3: Keperluan
            'keperluan' => 'required|in:industri_kayu,pertambangan,pariwisata,perkebunan,lainnya',

            // Step 4: Dampak
            'alasan' => 'required|string',
            'dampak_lingkungan' => 'nullable|string',

            // Step 5: Dokumen
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB
        ]);

        $user = Auth::user();

        // 2. Update User Profile if changed
        if ($user->company_name !== $request->company_name || $user->address !== $request->address) {
            $user->update([
                'company_name' => $request->company_name,
                'address' => $request->address,
            ]);
        }

        // 3. Handle File Upload
        $dokumenPaths = ['npwp' => $request->npwp]; // Store NPWP here for now
        if ($request->hasFile('dokumen_pendukung')) {
            $path = $request->file('dokumen_pendukung')->store('documents', 'public');
            $dokumenPaths['main_document'] = $path;
        }

        // 4. Create Laporan
        Laporan::create([
            'user_id' => $user->id,
            'nomor_laporan' => 'LAP-' . time() . '-' . mt_rand(1000, 9999),
            'judul' => 'Pengajuan ' . ucwords(str_replace('_', ' ', $request->keperluan)) . ' - ' . $request->company_name,
            'keperluan' => $request->keperluan,
            'lokasi_polygon' => json_decode($request->lokasi_polygon, true), // Cast to array
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'luas_dimohon' => $request->luas_dimohon,
            'alasan' => $request->alasan,
            'dampak_lingkungan' => $request->dampak_lingkungan,
            'dokumen' => $dokumenPaths,
            'status' => 'pending', // Directly pending for now
        ]);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diajukan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Laporan $report)
    {
        // Ensure the report belongs to the authenticated user
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reports.show', compact('report'));
    }
}
