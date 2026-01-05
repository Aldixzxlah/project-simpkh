<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports.
     */
    public function index()
    {
        $reports = Laporan::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Display the specified report.
     */
    public function show(Laporan $report)
    {
        $report->load('user');
        return view('admin.reports.show', compact('report'));
    }

    /**
     * Update the specified report in storage.
     */
    public function update(Request $request, Laporan $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? null,
            // In a real app, we might want to store who approved it
            // 'reviewed_by' => Auth::id(),
            // 'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.reports.show', $report)
            ->with('success', 'Laporan berhasil diperbarui.');
    }
}
