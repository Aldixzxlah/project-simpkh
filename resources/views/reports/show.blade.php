<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <a href="{{ route('reports.index') }}"
                class="inline-flex items-center mb-6 text-sm font-medium text-gray-500 hover:text-forest-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Riwayat Laporan
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Header -->
                <div class="flex justify-between items-start mb-6 border-b pb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-forest-900">Laporan #{{ $report->nomor_laporan }}</h1>
                        <p class="text-sm text-gray-500">Diajukan pada {{ $report->created_at->format('d F Y, H:i') }}
                        </p>
                    </div>
                    <div>
                        @if($report->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 text-sm font-bold px-3 py-1 rounded-full">Menunggu
                                Review</span>
                        @elseif($report->status == 'approved')
                            <span
                                class="bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full">Disetujui</span>
                        @elseif($report->status == 'rejected')
                            <span class="bg-red-100 text-red-800 text-sm font-bold px-3 py-1 rounded-full">Ditolak</span>
                        @else
                            <span
                                class="bg-gray-100 text-gray-800 text-sm font-bold px-3 py-1 rounded-full">{{ ucfirst($report->status) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Admin Notes (If any) -->
                @if($report->catatan_admin)
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <span class="font-bold">Catatan dari Admin:</span>
                                    {{ $report->catatan_admin }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Content Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Column 1 -->
                    <div>
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Identitas Perusahaan</h3>
                            <p class="text-gray-900 font-medium">
                                {{ $report->user->company_name ?? $report->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $report->user->address }}</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Jenis Keperluan</h3>
                            <p class="text-gray-900 font-medium">{{ ucfirst($report->keperluan) }}</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Judul Laporan</h3>
                            <p class="text-lg text-gray-800">{{ $report->judul }}</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Analisis Dampak Lingkungan
                            </h3>
                            <div class="bg-gray-50 p-4 rounded-lg text-gray-700 whitespace-pre-wrap text-sm">
                                {{ $report->dampak_lingkungan ?? '-' }}</div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div>
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Lokasi</h3>
                            <p class="text-gray-700 text-sm mb-2"><span class="font-medium">Koordinat:</span>
                                {{ $report->latitude ?? '-' }}, {{ $report->longitude ?? '-' }}</p>
                            <p class="text-gray-700 text-sm mb-2"><span class="font-medium">Luas Dimohon:</span>
                                {{ number_format($report->luas_dimohon) }} Ha</p>

                            <!-- Placeholder Map -->
                            <div id="map-preview"
                                class="h-48 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-sm">
                                @if($report->latitude && $report->longitude)
                                    Map Preview Loading...
                                @else
                                    No Map Data
                                @endif
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Dokumen Pendukung</h3>
                            @if(isset($report->dokumen) && is_array($report->dokumen) && isset($report->dokumen['main_document']))
                                <a href="{{ asset('storage/' . $report->dokumen['main_document']) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Lihat Dokumen
                                </a>
                            @else
                                <p class="text-sm text-gray-500 italic">Tidak ada dokumen dilampirkan.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Alasan Penggunaan Lahan</h3>
                    <div class="bg-gray-50 p-4 rounded-lg text-gray-700 whitespace-pre-wrap">{{ $report->alasan }}</div>
                </div>

            </div>
        </div>
    </div>

    <!-- Map Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if($report->latitude && $report->longitude)
                setTimeout(() => {
                    var map = L.map('map-preview').setView([{{ $report->latitude }}, {{ $report->longitude }}], 10);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);
                    L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(map);
                }, 100);
            @endif
        });
    </script>
</x-app-layout>