<?php

namespace App\Http\Controllers;

use App\Models\DataHutan;
use App\Models\Laporan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // 1. Calculate Total Forest Area
        $totalForestArea = DataHutan::sum('luas_hektar');

        // 2. Count Reports
        $totalReports = Laporan::count();
        $pendingReports = Laporan::where('status', 'pending')->count();
        $approvedReports = Laporan::where('status', 'approved')->count();

        // 3. Prepare data for charts (mock logic for now or simple aggregation)
        // Group by province for table/chart
        $forestByProvince = DataHutan::selectRaw('provinsi, sum(luas_hektar) as total_luas')
            ->groupBy('provinsi')
            ->orderByDesc('total_luas')
            ->take(5)
            ->get();

        // 4. Data for Map (All Provinces)
        $mapData = DataHutan::selectRaw('provinsi, sum(luas_hektar) as total_luas')
            ->groupBy('provinsi')
            ->get();

        if ($request->user()->role === 'admin') {
            return view('admin.dashboard', compact(
                'totalForestArea',
                'totalReports',
                'pendingReports',
                'approvedReports',
                'forestByProvince',
                'mapData'
            ));
        }

        // User specific stats (Only 'produksi' forests)
        $userForestArea = DataHutan::where('status_konservasi', 'produksi')->sum('luas_hektar');

        $userForestByProvince = DataHutan::where('status_konservasi', 'produksi')
            ->selectRaw('provinsi, sum(luas_hektar) as total_luas')
            ->groupBy('provinsi')
            ->orderByDesc('total_luas')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalForestArea', // Keep global total available if needed, or replace
            'userForestArea',
            'totalReports',
            'pendingReports',
            'approvedReports',
            'userForestByProvince', // Use filtered list for user
            'mapData'
        ));
    }
}
