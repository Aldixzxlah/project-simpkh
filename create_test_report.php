<?php

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = User::first();
if (!$user) {
    die("No user found.");
}

Auth::login($user);

$data = [
    'user_id' => $user->id,
    'nomor_laporan' => 'LAP-TEST-' . time(),
    'judul' => 'Laporan Test Koordinat',
    'keperluan' => 'pertambangan',
    'lokasi_polygon' => ['type' => 'Polygon', 'coordinates' => []],
    'latitude' => -6.9175,
    'longitude' => 107.6191,
    'luas_dimohon' => 50,
    'alasan' => 'Testing coordinates',
    'dampak_lingkungan' => 'None',
    'dokumen' => ['main_document' => 'test.pdf'],
    'status' => 'pending',
];

$report = Laporan::create($data);

echo "Created Report ID: " . $report->id . "\n";
echo "Latitude: " . $report->latitude . "\n";
echo "Longitude: " . $report->longitude . "\n";
