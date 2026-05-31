<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-black text-2xl text-slate-800 dark:text-white">
                    Data Barang
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Management barang inventaris
                </p>

            </div>

            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-location')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold text-sm">

                + Tambah Barang

            </button>

        </div>

    </x-slot>

    <div class="py-10 bg-[#F8FAFC] dark:bg-slate-950 min-h-screen">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                {{-- ALERT --}}
                <div x-data="{ show: true }" x-show="show"
                    class="mb-6 flex items-center justify-between bg-blue-100 border border-blue-300 text-blue-700 px-6 py-4 rounded-2xl">

                    <span class="font-semibold">
                        {{ session('success') }}
                    </span>

                    <button @click="show = false">
                        ✕
                    </button>

                </div>
            @endif



            {{-- TABLE --}}
            <div class="bg-white dark:bg-slate-700 rounded-md overflow-hidden">

                <table class="w-full">

                    <thead class="bg-slate-200 dark:bg-slate-800">

                        <tr class="text-xs uppercase tracking-[0.2em] text-slate-600 dark:text-slate-200">

                            <th class="px-8 py-5 text-left">Nama Barang</th>
                            <th class="px-8 py-5 text-left">Lokasi Penyimpanan</th>
                            <th class="px-8 py-5 text-left">Status</th>
                            <th class="px-8 py-5 text-left">Pilihan</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($items as $item)
                            <tr class="text-slate-600 dark:text-slate-300"">

                                <td class="px-8 py-6"> {{ $item->item_name }} </td>
                                <td class="px-8 py-6 font-bold">
                                    {{ $item->location->room_name }}
                                </td>
                                <td class="px-8 py-6 {{ $item->status == 'good' ? 'text-emerald-500' : ($item->status == 'broke' ? 'text-rose-500' : 'text-yellow-500') }}  font-bold">
                                    {{ $item->status == 'good' ? 'kondisi baik' : ($item->status == 'broke' ? 'kondisi rusak' : 'sedang maintenance') }}
                                </td>
                                <td>
                                    <a href="{{ route('item.show', $item->uuid) }}" class="px-8 py-6 font-bold text-blue-500">Detail</a>
                                </td>
                            </tr>
                        @empty
                        <tr class="text-slate-600 dark:text-slate-300">
                            <td colspan="4" class="px-8 py-6 text-center">Barang tidak tersedia</td>
                        </tr>
                        @endforelse



                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- MODAL --}}
    <x-modal name="create-location" :show="false" focusable>

        <div class="p-8">

            <h2 class="text-2xl dark:text-slate-200 font-black mb-6">
                Tambah barang
            </h2>

            <form action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <x-input-label for="namaBarang" :value="__('Nama Barang')" />
                    <x-text-input id="namaBarang" class="block mt-1 w-full" type="text" name="namaBarang"
                        :value="old('namaBarang')" required />
                    <x-input-error :messages="$errors->get('namaBarang')" class="mt-2" />
                </div>
                  <div class="mb-4">
                    <x-input-label for="namaLokasi" :value="__('Lokasi Penyimpanan')" />
                    <select name="namaLokasi" id="namaLokasi" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="" disabled>Pilih Lokasi</option>
                       @forelse ($locations as $location)
                            <option value="{{$location->id}}" >{{$location->room_name}}</option>
                       @empty
                            <option value="" disabled>Lokasi sudah full</option>
                        @endforelse
                    </select>
                   
                    <x-input-error :messages="$errors->get('namaLokasi')" class="mt-2" />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status Barang')" />

                        <div class="flex gap-4 mt-3">
                            @foreach (['good', 'broke', 'maintenance'] as $status)
                                <label class="flex item-center gap-2">
                                    <input type="radio" name="status" value="{{ $status }}" id="status"
                                        {{ old('status') == $status ? 'checked' : '' }}
                                        class="border-slate-300 text-indigo-600 focus:ring-indigo-500">

                                    <span class="capitalize text-slate-200">
                                        {{ $status }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="category" :value="__('Category Barang')" />

                        <div class="grid grid-cols-2 mt-2">
                            @foreach (['makanan', 'elektronik', 'atk', 'logistik', 'lainnya'] as $category)
                                <label class="flex item-center gap-2">
                                    <input type="radio" name="category" value="{{ $category }}" id="category"
                                        {{ old('category') == $category ? 'checked' : '' }}
                                        class="border-slate-300 text-indigo-600 focus:ring-indigo-500">

                                    <span class="capitalize text-slate-200">
                                        {{ $category }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    
                </div>

                <div class="mb-4">
                    <x-input-label for="gambarBarang" :value="__('Gambar Barang')" />
                    <x-text-input id="gambarBarang" class="block mt-1 w-full py-4 px-6 border" type="file" name="gambarBarang"
                        :value="old('gambarBarang')" required />
                    <x-input-error :messages="$errors->get('gambarBarang')" class="mt-2" />
                </div>


                <div class="mb-4">
                    <x-input-label for="deksripsi" :value="__('Deskripsi barang')" />
                    <textarea name="deskripsi" id="deskripsi"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('deksripsi')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold text-sm">Tambah
                        Barang</button>
                </div>


            </form>



        </div>

    </x-modal>

</x-app-layout>
