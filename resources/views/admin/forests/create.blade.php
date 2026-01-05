<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Hutan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.forests.store') }}" method="POST" x-data="forestForm()">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Left Column: Form Fields -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Provinsi (Otomatis)</label>
                                    <input type="text" name="provinsi" id="provinsi_input" value="{{ old('provinsi') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-forest-500 focus:ring-forest-500 cursor-not-allowed"
                                        readonly required>
                                    @error('provinsi') <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pulau (Otomatis)</label>
                                    <input type="text" name="pulau" id="pulau_input" value="{{ old('pulau') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-forest-500 focus:ring-forest-500 cursor-not-allowed"
                                        readonly>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Latitude</label>
                                        <input type="text" name="latitude" id="lat_input" value="{{ old('latitude') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm font-mono text-xs cursor-not-allowed"
                                            readonly required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Longitude</label>
                                        <input type="text" name="longitude" id="lng_input"
                                            value="{{ old('longitude') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm font-mono text-xs cursor-not-allowed"
                                            readonly required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Luas (Hektar)</label>
                                    <input type="number" step="0.01" name="luas_hektar" value="{{ old('luas_hektar') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Konservasi</label>
                                    <select name="status_konservasi"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500">
                                        <option value="konservasi">Hutan Konservasi</option>
                                        <option value="lindung">Hutan Lindung</option>
                                        <option value="produksi">Hutan Produksi</option>
                                        <option value="konversi">Hutan Konversi</option>
                                    </select>
                                </div>

                                <input type="hidden" name="geojson" id="geojson_input">
                            </div>

                            <!-- Right Column: Map -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Hutan (Klik Peta)</label>
                                <div id="map-draw" class="h-96 w-full rounded-lg border border-gray-300 z-0"></div>
                                <p class="text-xs text-gray-500 mt-2"><strong>Klik pada peta</strong> untuk menentukan titik lokasi. Provinsi dan Pulau akan terisi otomatis.</p>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.forests.index') }}"
                                class="mr-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest-500">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-forest-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-forest-700 focus:bg-forest-700 active:bg-forest-900 focus:outline-none focus:ring-2 focus:ring-forest-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS/JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map-draw').setView([-2.5489, 118.0149], 5); // Center Indonesia

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Marker for Pinpoint Location
            var marker = null;

            // Handle Map Click (Coordinate Picking + Reverse Geocoding)
            map.on('click', function (e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                // Update Lat/Lng Inputs
                document.getElementById('lat_input').value = lat.toFixed(8);
                document.getElementById('lng_input').value = lng.toFixed(8);

                // Show Loading State
                document.getElementById('provinsi_input').value = "Mengambil data...";
                document.getElementById('pulau_input').value = "Mengambil data...";

                // Move/Create Marker and Update GeoJSON (Point)
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }

                // Store Point GeoJSON
                var pointGeoJSON = marker.toGeoJSON();
                document.getElementById('geojson_input').value = JSON.stringify(pointGeoJSON);

                // Reverse Geocoding (Nominatim)
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal mengambil data lokasi');
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.address) {
                            // Try to find state/province (handle various Nominatim keys)
                            var province = data.address.state ||
                                data.address.province ||
                                data.address.region ||
                                data.address.city || // For Jakarta/Yogya
                                data.address.island || // For small islands
                                '';

                            document.getElementById('provinsi_input').value = province || 'Tidak ditemukan';

                            // Simple Island Inference based on Province
                            document.getElementById('pulau_input').value = inferIsland(province) || inferIsland(data.address.archipelago) || 'Lainnya';
                        } else {
                            document.getElementById('provinsi_input').value = "Lokasi tidak dikenali";
                            document.getElementById('pulau_input').value = "-";
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('provinsi_input').value = "Error koneksi";
                        document.getElementById('pulau_input').value = "-";
                        alert("Gagal mengambil data lokasi. Pastikan koneksi internet lancar.");
                    });
            });

            function inferIsland(province) {
                if (!province) return '';
                const p = province.toLowerCase();

                // Major Islands Matching
                if (p.includes('sumatera') || p.includes('aceh') || p.includes('riau') || p.includes('jambi') || p.includes('lampung') || p.includes('bengkulu') || p.includes('medan') || p.includes('padang') || p.includes('palembang') || p.includes('bangka') || p.includes('belitung')) return 'Sumatera';

                if (p.includes('jawa') || p.includes('banten') || p.includes('jakarta') || p.includes('yogyakarta') || p.includes('bandung') || p.includes('semarang') || p.includes('surabaya')) return 'Jawa';

                if (p.includes('kalimantan') || p.includes('pontianak') || p.includes('banjarmasin') || p.includes('samarinda')) return 'Kalimantan';

                if (p.includes('sulawesi') || p.includes('gorontalo') || p.includes('makassar') || p.includes('manado') || p.includes('palu') || p.includes('kendari')) return 'Sulawesi';

                if (p.includes('papua') || p.includes('irian') || p.includes('jayapura') || p.includes('manokwari') || p.includes('sorong') || p.includes('merauke')) return 'Papua';

                if (p.includes('bali')) return 'Bali';
                if (p.includes('nusa tenggara')) return 'Nusa Tenggara';
                if (p.includes('maluku') || p.includes('ambon') || p.includes('ternate')) return 'Maluku';

                return '';
            }
        });
    </script>
</x-app-layout>