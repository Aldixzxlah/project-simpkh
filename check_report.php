<?php

use App\Models\Laporan;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$report = Laporan::find(3);

if ($report) {
    echo "Report ID: " . $report->id . "\n";
    echo "Latitude: " . ($report->latitude ?? 'NULL') . "\n";
    echo "Longitude: " . ($report->longitude ?? 'NULL') . "\n";
    echo "Fillable: " . implode(', ', $report->getFillable()) . "\n";
} else {
    echo "Report 3 not found.\n";
}
