<x-app-layout>
    <!-- Map Container (Full Height relative to parent) -->
    <div class="relative w-full h-full z-0">
        <div id="map" class="w-full h-full z-0"></div>

        <!-- Floating Stats Panel -->
        <div x-data="{ open: true }"
            class="absolute top-4 left-4 z-[400] w-80 lg:w-96 bg-white/90 backdrop-blur-md rounded-xl shadow-xl border border-white/50 p-4 overflow-y-auto max-h-[80vh] transition-all duration-300">
            <h2 class="text-lg font-bold text-forest-900 mb-3 border-b border-forest-100 pb-2 flex justify-between items-center cursor-pointer"
                @click="open = !open">
                <span>Admin Dashboard</span>
                <div class="flex items-center">
                    <span class="text-xs bg-forest-100 text-forest-800 px-2 py-1 rounded-full mr-2">Administrator</span>
                    <button type="button" class="text-forest-500 hover:text-forest-700 focus:outline-none">
                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7">
                            </path>
                        </svg>
                        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                </div>
            </h2>

            <!-- Collapsible Content -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2">

                <!-- Main Stat Card -->
                <div class="bg-forest-50 rounded-lg p-3 mb-4 border border-forest-100">
                    <p class="text-xs text-forest-600 uppercase font-semibold">Total Luas Berhutan</p>
                    <p class="text-2xl font-bold text-forest-800">{{ number_format($totalForestArea, 0, ',', '.') }} Ha
                    </p>
                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                        <div class="bg-forest-500 h-1.5 rounded-full" style="width: 51%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Data Global Sistem</p>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <div class="bg-white p-2 rounded-lg border border-gray-100 shadow-sm">
                        <p class="text-xs text-gray-500 uppercase">Total User</p>
                        <p class="text-xl font-bold text-gray-800">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="bg-white p-2 rounded-lg border border-gray-100 shadow-sm">
                        <p class="text-xs text-gray-500 uppercase">Laporan Masuk</p>
                        <p class="text-xl font-bold text-gray-800">{{ $totalReports }}</p>
                    </div>
                </div>

                <!-- Report Statuses -->
                <div class="grid grid-cols-3 gap-2 mb-4 text-center">
                    <div class="bg-yellow-50 p-2 rounded border border-yellow-100">
                        <p class="text-[10px] text-yellow-600 uppercase font-bold">Pending</p>
                        <p class="text-lg font-bold text-yellow-700">{{ $pendingReports }}</p>
                    </div>
                    <div class="bg-green-50 p-2 rounded border border-green-100">
                        <p class="text-[10px] text-green-600 uppercase font-bold">Approved</p>
                        <p class="text-lg font-bold text-green-700">{{ $approvedReports }}</p>
                    </div>
                    <div class="bg-red-50 p-2 rounded border border-red-100">
                        <p class="text-[10px] text-red-600 uppercase font-bold">Rejected</p>
                        <p class="text-lg font-bold text-red-700">
                            {{ \App\Models\Laporan::where('status', 'rejected')->count() }}
                        </p>
                    </div>
                </div>

                <!-- Additional Info / Actions -->
                <div class="grid grid-cols-1 gap-2 text-center">
                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                        <p class="text-xs text-blue-800 mb-2">Aksi Cepat</p>
                        <div class="flex justify-around">
                            <a href="{{ route('admin.forests.create') }}"
                                class="text-xs bg-forest-600 text-white px-3 py-1 rounded shadow-sm font-bold border border-transparent hover:bg-forest-700 transition-colors">Tambah
                                Hutan</a>
                            <a href="{{ route('admin.forests.index') }}"
                                class="text-xs bg-white text-blue-700 px-3 py-1 rounded shadow-sm font-bold border border-blue-200 hover:bg-blue-50">Kelola
                                Hutan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for Map -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Coordinate Center of Indonesia
            const map = L.map('map').setView([-2.5, 118], 5);

            // Tiles (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                minZoom: 4
            }).addTo(map);

            // Dummy GeoJSON Data (Approximation circles/polygons for demo)
            // Dictionary of Province Coordinates (Center Points)
            const provinceCoords = {
                "Aceh": { coords: [4.6951, 96.7494], color: "#166534" },
                "Sumatera Utara": { coords: [2.1154, 99.5451], color: "#15803d" },
                "Sumatera Barat": { coords: [-0.7399, 100.8000], color: "#16a34a" },
                "Riau": { coords: [0.2933, 101.7068], color: "#22c55e" },
                "Jambi": { coords: [-1.6101, 103.6131], color: "#4ade80" },
                "Sumatera Selatan": { coords: [-3.3194, 104.9144], color: "#86efac" },
                "Bengkulu": { coords: [-3.7928, 102.2608], color: "#bbf7d0" },
                "Lampung": { coords: [-4.5586, 105.4068], color: "#dcfce7" },
                "Jawa Barat": { coords: [-6.9175, 107.6191], color: "#166534" },
                "Jawa Tengah": { coords: [-7.1510, 110.1403], color: "#15803d" },
                "Jawa Timur": { coords: [-7.5360, 112.2384], color: "#16a34a" },
                "Kalimantan Barat": { coords: [-0.2787, 111.4753], color: "#166534" },
                "Kalimantan Tengah": { coords: [-1.6815, 113.3824], color: "#15803d" },
                "Kalimantan Selatan": { coords: [-3.0926, 115.2838], color: "#16a34a" },
                "Kalimantan Timur": { coords: [0.5387, 116.4194], color: "#22c55e" },
                "Kalimantan Utara": { coords: [3.0731, 116.0414], color: "#4ade80" },
                "Sulawesi Utara": { coords: [0.6274, 123.9750], color: "#166534" },
                "Sulawesi Tengah": { coords: [-1.4300, 121.4456], color: "#15803d" },
                "Sulawesi Selatan": { coords: [-3.6687, 119.9740], color: "#16a34a" },
                "Papua": { coords: [-4.2699, 138.0804], color: "#166534" },
                "Papua Barat": { coords: [-1.3361, 133.1747], color: "#15803d" },
                // Fallbacks/Generic Islands
                "Sumatera": { coords: [-0.5, 101.5], color: "#16a34a" },
                "Kalimantan": { coords: [-1.0, 114.0], color: "#15803d" },
                "Jawa": { coords: [-7.5, 110.0], color: "#4ade80" },
                "Sulawesi": { coords: [-2.0, 120.0], color: "#22c55e" }
            };

            // Real Data from Controller
            const mapData = @json($mapData);

            mapData.forEach(item => {
                let region = provinceCoords[item.provinsi];

                // If specific province not found, try to match by word
                if (!region) {
                    for (const key in provinceCoords) {
                        if (item.provinsi.includes(key)) {
                            region = provinceCoords[key];
                            break;
                        }
                    }
                }

                if (region) {
                    // Normalize radius (sqrt for area to radius relationship)
                    const radius = Math.sqrt(item.total_luas) * 50;

                    L.circle(region.coords, {
                        color: region.color,
                        fillColor: region.color,
                        fillOpacity: 0.5,
                        radius: radius
                    }).addTo(map)
                        .bindPopup(`<b>${item.provinsi}</b><br>Luas Hutan: ${new Intl.NumberFormat('id-ID').format(item.total_luas)} Ha`);
                }
            });
        });
    </script>
</x-app-layout>