<x-app-layout>
    <div class="py-6 px-4 md:px-8 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-forest-900">Riwayat Laporan</h1>
                <p class="text-forest-600">Pantau status laporan penggunaan lahan Anda.</p>
            </div>
            <!-- 
            <div class="mt-4 md:mt-0 flex space-x-2">
                <input type="text" placeholder="Cari laporan..."
                    class="rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 text-sm p-2 border">
                <select
                    class="rounded-md border-gray-300 shadow-sm focus:border-forest-500 focus:ring-forest-500 text-sm p-2 border">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu Review</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
             -->
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-forest-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-forest-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-forest-800 uppercase tracking-wider">
                                Nomor Laporan</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-forest-800 uppercase tracking-wider">
                                Tanggal</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-forest-800 uppercase tracking-wider">
                                Luas / Jenis</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-forest-800 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-forest-800 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($reports as $report)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $report->nomor_laporan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $report->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="font-medium text-gray-900">{{ number_format($report->luas_dimohon) }} Ha
                                    </div>
                                    <div class="text-xs text-gray-400">{{ ucfirst($report->keperluan) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($report->status == 'pending')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Menunggu Review
                                        </span>
                                    @elseif($report->status == 'approved')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @elseif($report->status == 'rejected')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('reports.show', $report) }}"
                                        class="text-forest-600 hover:text-forest-900">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Anda belum mengajukan laporan apapun.
                                    <br>
                                    <a href="{{ route('reports.create') }}"
                                        class="text-forest-600 hover:underline mt-2 inline-block">Ajukan Laporan Baru</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</x-app-layout>