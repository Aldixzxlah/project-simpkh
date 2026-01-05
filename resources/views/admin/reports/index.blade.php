<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Laporan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Tanggal</th>
                                    <th scope="col" class="py-3 px-6">Pelapor</th>
                                    <th scope="col" class="py-3 px-6">Jenis</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                    <th scope="col" class="py-3 px-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reports as $report)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6">
                                            {{ $report->created_at->format('d M Y') }}
                                            <br>
                                            <span
                                                class="text-xs text-gray-400">{{ $report->created_at->format('H:i') }}</span>
                                        </td>
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $report->user->name }}
                                            <br>
                                            <span class="text-xs text-gray-400">{{ $report->user->email }}</span>
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ ucfirst($report->jenis_laporan) }}
                                        </td>
                                        <td class="py-4 px-6">
                                            @if($report->status == 'pending')
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Pending</span>
                                            @elseif($report->status == 'approved')
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Approved</span>
                                            @elseif($report->status == 'rejected')
                                                <span
                                                    class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <a href="{{ route('admin.reports.show', $report) }}"
                                                class="font-medium text-forest-600 hover:text-forest-800 hover:underline">Review</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-6 text-center text-gray-500">Belum ada laporan masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $reports->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>