<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-black text-2xl text-slate-800 dark:text-white">
                    Detail Barang
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    {{ $item->item_name }}
                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-location')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold btn-sm text-sm">
                    Edit Barang
                </button>

                <form action="{{ route('item.delete', $item->uuid) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" onclick="return confirm('Yakin mau dihapus?')"
                        class="bg-rose-600 hover:bg-rose-700 text-white px-6 py-3 rounded-2xl font-bold btn-sm text-sm">
                        Hapus Barang
                    </button>
                </form>


            </div>



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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white dark:bg-slate-700 rounded-md overflow-hidden">

                    <table class="w-full">

                        <tbody>


                            <tr class="text-slate-600 dark:text-slate-300"">

                            <th class=" px-8 py-6 text-left"> Nama Barang </th>
                                <td class="px-8 py-6 text-left"> {{ $item->item_name }} </td>

                            </tr>

                            <tr class="text-slate-600 dark:text-slate-300"">

                            <th class=" px-8 py-6 text-left"> Penyimpanan </th>
                                <td class="px-8 py-6 text-left"> {{ $item->location->room_name }} </td>

                            </tr>


                            <tr class="text-slate-600 dark:text-slate-300"">

                            <th class=" px-8 py-6 text-left"> Kategori </th>
                                <td class="px-8 py-6 text-left capitalize"> {{ $item->category }} </td>
                            </tr>

                            <tr class="text-slate-600 dark:text-slate-300"">

                            <th class=" px-8 py-6 text-left"> Status </th>
                                <td
                                    class="px-8 py-6 {{ $item->status == 'good' ? 'text-emerald-500' : ($item->status == 'broke' ? 'text-rose-500' : 'text-yellow-500') }}  font-bold">
                                    {{ $item->status == 'good' ? 'kondisi baik' : ($item->status == 'broke' ? 'kondisi rusak' : 'sedang maintenance') }}
                                </td>
                            </tr>


                            <tr class="text-slate-600 dark:text-slate-300"">

                            <th class=" px-8 py-6 text-left"> Deskripsi </th>
                                <td class="px-8 py-6 text-left"> {{ $item->desc }} </td>
                            </tr>

                        </tbody>

                    </table>

                </div>
                <div class="bg-white dark:bg-slate-700 rounded-md overflow-hidden p-4">
                    <img src="{{asset('storage/images/items/' . $item->image)}}" class="rounded-md" alt="" class="img-fluid">
                </div>
            </div>



            {{-- TABLE --}}


        </div>

    </div>

    {{-- MODAL --}}
    <x-modal name="create-location" :show="false" focusable>

        <div class="p-8">

            <h2 class="text-2xl dark:text-slate-200 font-black mb-6">
                Edit Barang
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
