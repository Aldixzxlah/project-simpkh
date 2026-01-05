<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Data Hutan') }}
            </h2>
            <a href="{{ route('admin.forests.create') }}"
                class="inline-flex items-center px-4 py-2 bg-forest-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-forest-700 focus:bg-forest-700 active:bg-forest-900 focus:outline-none focus:ring-2 focus:ring-forest-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Data Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Kawasan Hutan</h3>
                        <a href="{{ route('admin.forests.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-forest-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-forest-700 focus:bg-forest-700 active:bg-forest-900 focus:outline-none focus:ring-2 focus:ring-forest-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Data
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Provinsi</th>
                                    <th scope="col" class="py-3 px-6">Pulau</th>
                                    <th scope="col" class="py-3 px-6">Luas (Ha)</th>
                                    <th scope="col" class="py-3 px-6">Status Konservasi</th>
                                    <th scope="col" class="py-3 px-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($forests as $forest)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $forest->provinsi }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $forest->pulau }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ number_format($forest->luas_hektar, 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">{{ ucfirst($forest->status_konservasi) }}</span>
                                        </td>
                                        <td class="py-4 px-6 text-right flex justify-end gap-2">
                                            <a href="{{ route('admin.forests.edit', $forest) }}"
                                                class="inline-flex items-center px-3 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.forests.destroy', $forest) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-6 text-center text-gray-500">Belum ada data hutan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $forests->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>