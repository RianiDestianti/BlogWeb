<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Pengaturan Blog
            <a href="{{ route('member.blogs.create') }}" class="bg-blue-500 hover:bg-blue-600 p-3 rounded-md text-white text-sm ml-4">
                Tambah Tulisan
            </a>
        </h2>
    </x-slot>

    <x-slot name="headerRight">
        <form action="{{ route('member.blogs.index') }}" method="get" class="flex items-center mt-3 md:mt-0">
            <x-text-input id='search' name='search' type='text' class="p-2 m-0 md:w-72 w-80 rounded-md border border-gray-300" value="{{ request('search') }}" placeholder="Masukan Kata Kunci..."></x-text-input>
            <x-secondary-button class="ml-2 p-2" type='submit'>Cari</x-secondary-button>
        </form>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-x-auto">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-center font-semibold text-gray-700 bg-gray-100">
                                <td class="border px-6 py-4">No</td>
                                <td class="border px-6 py-4">Judul</td>
                                <td class="border px-6 py-4 hidden lg:table-cell">Tanggal</td>
                                <td class="border px-6 py-4 hidden lg:table-cell">Status</td>
                                @if (auth()->user()->role == 1)
                                <td class="border px-6 py-4">Aksi</td>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Post as $item)
                                <tr class="text-center hover:bg-gray-100 transition-all">
                                    <td class="border px-6 py-4">{{ $Post->firstItem() + $loop->index }}</td>
                                    <td class="border px-6 py-4">
                                        {{ $item->title }}
                                        <div class="block lg:hidden text-sm text-gray-500">
                                            {{ $item->status }} | {{ $item->created_at->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                    </td>
                                    <td class="border px-6 py-4 text-gray-500 text-sm hidden lg:table-cell">
                                        {{ $item->created_at->isoFormat('dddd, D MMMM Y') }}
                                    </td>
                                    <td class="border px-6 py-4 text-sm hidden lg:table-cell">
                                        {{ $item->status }}
                                    </td>
                                    @if (auth()->user()->role == 1)
                                    <td class="border px-6 py-4 text-center">
                                        <a href="{{ route('member.blogs.edit', ['post' => $item->id]) }}" class="text-blue-600 hover:text-blue-400 px-2">edit</a>

                                        <a target='_blank' href="{{ route('blog-detail', ['slug' => $item->slug]) }}" class="text-blue-600 hover:text-blue-400 px-2">lihat</a>

                                        <form class="inline" onsubmit="return confirm('Yakin Menghapus Data Ini?')" method="POST" action="{{ route('member.blogs.destroy', ['post' => $item->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="text-red-600 hover:text-red-400 px-2">hapus</button>
                                        </form>
                                    </td>
                                    @endif
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-5">
                    {{ $Post->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
