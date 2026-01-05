<x-app-layout>
    <div class="py-6 px-4 md:px-8 max-w-7xl mx-auto" x-data="{ 
        step: 1, 
        totalSteps: 5,
        nextStep() { if (this.step < this.totalSteps) this.step++ },
        prevStep() { if (this.step > 1) this.step-- }
    }">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-forest-900">Ajukan Laporan Baru</h1>
            <p class="text-forest-600">Formulir pengajuan penggunaan lahan hutan.</p>
        </div>

        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between relative">
                    <div class="absolute w-full h-2 bg-gray-200 rounded-full -z-10"></div>
                    <template x-for="i in totalSteps">
                        <div :class="{'bg-forest-600 text-white border-forest-600': step >= i, 'bg-white text-gray-400 border-gray-300': step < i}"
                            class="w-10 h-10 flex items-center justify-center rounded-full border-2 font-bold transition-colors duration-300 z-10"
                            x-text="i"></div>
                    </template>
                </div>
                <div class="flex justify-between mt-2 text-xs font-medium text-gray-500">
                    <span>Lokasi</span>
                    <span>Perusahaan</span>
                    <span>Keperluan</span>
                    <span>Dampak</span>
                    <span>Dokumen</span>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-forest-100 p-6 md:p-8">
                <!-- Step 1: Lokasi -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300">
                    <h3 class="text-lg font-bold text-forest-800 mb-4">Step 1: Pilih Lokasi Area</h3>
                    <div
                        class="bg-gray-100 rounded-lg h-96 flex items-center justify-center border-2 border-dashed border-gray-300 mb-4 relative overflow-hidden">
                        <p class="text-gray-500 absolute z-10 pointer-events-none">Peta Seleksi Area (Leaflet Draw)</p>
                        <div id="map-select" class="w-full h-full"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Latitude</label>
                            <input type="text" id="latitude" name="latitude"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 p-2 border bg-gray-50 bg-white"
                                placeholder="Klik pada peta..." readonly required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Longitude</label>
                            <input type="text" id="longitude" name="longitude"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 p-2 border bg-gray-50 bg-white"
                                placeholder="Klik pada peta..." readonly required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Luas Area Terpilih (Ha)</label>
                            <input type="number" name="luas_dimohon"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 p-2 border bg-gray-50"
                                placeholder="0" value="150" required> <!-- Required added -->
                        </div>
                        <input type="hidden" name="lokasi_polygon"
                            value='{"type":"Polygon","coordinates":[[[100,0],[101,0],[101,1],[100,1],[100,0]]]}'>
                    </div>
                </div>

                <!-- Step 2: Perusahaan -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" style="display: none;">
                    <h3 class="text-lg font-bold text-forest-800 mb-4">Step 2: Identitas Perusahaan</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Perusahaan</label>
                            <input type="text" name="company_name" value="{{ Auth::user()->company_name ?? '' }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 p-2 border"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NPWP</label>
                            <input type="text" name="npwp"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 p-2 border"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <textarea name="address"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 p-2 border"
                                rows="3" required>{{ Auth::user()->address ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Keperluan -->
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" style="display: none;">
                    <h3 class="text-lg font-bold text-forest-800 mb-4">Step 3: Jenis Keperluan</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sektor Industri</label>
                        <select name="keperluan"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 p-2 border">
                            <option value="pertambangan">Pertambangan</option>
                            <option value="perkebunan">Perkebunan Sawit</option>
                            <option value="industri_kayu">Industri Kayu (HPH)</option>
                            <option value="pariwisata">Pariwisata Alam</option>
                            <option value="lainnya">Infrastruktur / Lainnya</option>
                        </select>
                    </div>
                </div>

                <!-- Step 4: Dampak -->
                <div x-show="step === 4" x-transition:enter="transition ease-out duration-300" style="display: none;">
                    <h3 class="text-lg font-bold text-forest-800 mb-4">Step 4: Analisis Dampak Lingkungan</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi Rencana Penggunaan
                            Lahan</label>
                        <textarea name="alasan"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 p-2 border"
                            rows="4" required placeholder="Jelaskan alasan penggunaan lahan..."></textarea>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Dampak Lingkungan & Mitigasi</label>
                        <textarea name="dampak_lingkungan"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 p-2 border"
                            rows="4" placeholder="Jelaskan dampak terhadap vegetasi dan rencana mitigasi..."></textarea>
                    </div>
                </div>

                <!-- Step 5: Dokumen -->
                <div x-show="step === 5" x-transition:enter="transition ease-out duration-300" style="display: none;">
                    <h3 class="text-lg font-bold text-forest-800 mb-4">Step 5: Upload Dokumen Pendukung</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dokumen PDF / Image (Max
                            10MB)</label>
                        <input type="file" name="dokumen_pendukung"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-forest-50 file:text-forest-700 hover:file:bg-forest-100" />
                    </div>

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48" aria-hidden="true">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-1 text-sm text-gray-600">Pastikan dokumen lengkap (AMDAL, Site Plan, dll)</p>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-8 flex justify-between">
                    <button type="button" @click="prevStep()" x-show="step > 1"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest-500">
                        Kembali
                    </button>
                    <div x-show="step === 1" class="hidden"></div> <!-- Spacer if no back button -->

                    <button type="button" @click="nextStep()" x-show="step < totalSteps"
                        class="ml-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-forest-600 hover:bg-forest-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest-500">
                        Lanjut
                    </button>

                    <button type="submit" x-show="step === totalSteps"
                        class="ml-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-forest-800 hover:bg-forest-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest-500">
                        Submit Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Map for Step 1
            // We need to wait for Alpine to show the div, or initialize it but invalidate size when shown
            // For prototype, we just init it. In real usage, use x-effect or $watch in Alpine.
            setTimeout(() => {
                if (document.getElementById('map-select')) {
                    var mapSelect = L.map('map-select').setView([-2.5, 118], 5);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(mapSelect);

                    var marker;
                    var selectedForestLayer = null;

                    // Forest Data from Controller
                    var forests = @json($forests);

                    forests.forEach(function (forest) {
                        if (forest.latitude && forest.longitude) {
                            // Calculate approximate radius based on area (sqrt(area) * scale)
                            // Adjust scale factor as needed for visibility
                            var radius = Math.sqrt(forest.luas_hektar) * 50;

                            var circle = L.circle([forest.latitude, forest.longitude], {
                                color: '#16a34a', // Forest Green
                                fillColor: '#16a34a',
                                fillOpacity: 0.5,
                                radius: radius,
                                className: 'cursor-pointer hover:fill-opacity-70' // Tailwin-ish class for pointer
                            }).addTo(mapSelect);

                            // Add Tooltip
                            circle.bindTooltip(`<b>${forest.provinsi}</b><br>Luas: ${new Intl.NumberFormat('id-ID').format(forest.luas_hektar)} Ha`, {
                                permanent: false,
                                direction: 'top'
                            });

                            // Click Handler for Selection
                            circle.on('click', function (e) {
                                // 1. Reset previous selection style
                                if (selectedForestLayer) {
                                    selectedForestLayer.setStyle({ color: '#16a34a', fillColor: '#16a34a' });
                                }

                                // 2. Highlight current selection
                                selectedForestLayer = circle;
                                circle.setStyle({ color: '#f59e0b', fillColor: '#f59e0b' }); // Amber/Orange highlight

                                // 3. Set Marker
                                if (marker) {
                                    marker.setLatLng([forest.latitude, forest.longitude]);
                                } else {
                                    marker = L.marker([forest.latitude, forest.longitude]).addTo(mapSelect);
                                }

                                // 4. Auto-fill Form
                                document.getElementById('latitude').value = forest.latitude;
                                document.getElementById('longitude').value = forest.longitude;

                                // Fill Area (luas_dimohon) with forest area (or user can edit)
                                document.querySelector('input[name="luas_dimohon"]').value = forest.luas_hektar;

                                // Optional: You might want to store the selected forest ID
                                // document.getElementById('data_hutan_id').value = forest.id;
                            });
                        }
                    });
                }
            }, 500);
        });
    </script>
</x-app-layout>