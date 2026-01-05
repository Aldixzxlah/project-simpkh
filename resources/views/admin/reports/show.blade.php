<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <a href="{{ route('admin.reports.index') }}"
                class="inline-flex items-center mb-6 text-sm font-medium text-gray-500 hover:text-forest-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Laporan
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content: Report Details -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-start mb-6 border-b pb-4">
                            <div>
                                <h1 class="text-2xl font-bold text-forest-900">Laporan #{{ $report->id }}</h1>
                                <p class="text-sm text-gray-500">Diajukan pada
                                    {{ $report->created_at->format('d F Y, H:i') }}
                                </p>
                            </div>
                            <div>
                                @if($report->status == 'pending')
                                    <span
                                        class="bg-yellow-100 text-yellow-800 text-sm font-bold px-3 py-1 rounded-full">Pending</span>
                                @elseif($report->status == 'approved')
                                    <span
                                        class="bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full">Approved</span>
                                @elseif($report->status == 'rejected')
                                    <span
                                        class="bg-red-100 text-red-800 text-sm font-bold px-3 py-1 rounded-full">Rejected</span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <h3 class="text-xs font-semibold text-gray-500 uppercase">Pelapor</h3>
                                <p class="text-gray-900 font-medium">{{ $report->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $report->user->email }}</p>
                            </div>
                            <div>
                                <h3 class="text-xs font-semibold text-gray-500 uppercase">Jenis Laporan</h3>
                                <p class="text-gray-900 font-medium">{{ ucfirst($report->jenis_laporan) }}</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Judul</h3>
                            <p class="text-lg text-gray-800">{{ $report->judul }}</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Deskripsi</h3>
                            <div class="bg-gray-50 p-4 rounded-lg text-gray-700 whitespace-pre-wrap">
                                {{ $report->deskripsi }}
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Lokasi</h3>
                            <p class="text-gray-700"><span class="font-medium">Koordinat:</span>
                                {{ $report->latitude }}, {{ $report->longitude }}</p>
                            <div id="map-preview"
                                class="mt-2 h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-sm">
                                @if($report->latitude && $report->longitude)
                                    Map Preview Loading...
                                @else
                                    No Map Data
                                @endif
                            </div>
                        </div>

                        @if($report->bukti_foto_path)
                            <div class="mb-6">
                                <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Bukti Foto</h3>
                                <img src="{{ asset('storage/' . $report->bukti_foto_path) }}" alt="Bukti Foto"
                                    class="max-w-full h-auto rounded-lg border">
                            </div>
                        @else
                            <div class="mb-6">
                                <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Bukti Foto</h3>
                                <p class="text-sm text-gray-500 italic">Tidak ada foto dilampirkan.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar: Actions -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Admin</h3>

                        @if(session('success'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                                role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('admin.reports.update', $report) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="catatan_admin" class="block text-sm font-medium text-gray-700 mb-1">Catatan
                                    Admin (Opsional)</label>
                                <textarea id="catatan_admin" name="catatan_admin" rows="3"
                                    class="shadow-sm focus:ring-forest-500 focus:border-forest-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Tambahkan catatan untuk pelapor...">{{ $report->catatan_admin }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button type="submit" name="status" value="rejected"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 {{ $report->status == 'rejected' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $report->status == 'rejected' ? 'disabled' : '' }}>
                                    Tolak
                                </button>
                                <button type="submit" name="status" value="approved"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 {{ $report->status == 'approved' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $report->status == 'approved' ? 'disabled' : '' }}>
                                    Setujui
                                </button>
                            </div>
                        </form>

                        @if($report->status != 'pending')
                            <div class="mt-4 pt-4 border-t text-sm text-gray-500">
                                <p>Terakhir diperbarui: {{ $report->updated_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
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