<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-black text-2xl text-slate-800 dark:text-white">
                    Detail Lokasi
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    {{ $location->room_name }}
                </p>

            </div>

            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-location')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold text-sm">

                Edit Lokasi

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

                    <tbody>


                        <tr class="text-slate-600 dark:text-slate-300"">

                            <th class="px-8 py-6 text-left"> Nama Ruangan </th>
                            <td class="px-8 py-6 text-left"> {{ $location->room_name }} </td>

                        </tr>


                        <tr class="text-slate-600 dark:text-slate-300"">

                            <th class="px-8 py-6 text-left"> Ukuran </th>
                            <td class="px-8 py-6 text-left"> {{ $location->size }} </td>
                        </tr>

                        <tr class="text-slate-600 dark:text-slate-300"">

                            <th class="px-8 py-6 text-left"> Availability </th>
                            <td
                                class="px-8 py-6 text-left {{ $location->isAvailable == true ? 'text-emerald-500' : 'text-rose-500' }}  font-bold">
                                {{ $location->isAvailable == true ? 'tersedia' : 'tidak tersedia / full' }}
                            </td>
                        </tr>


                        <tr class="text-slate-600 dark:text-slate-300"">

                            <th class="px-8 py-6 text-left"> Deskripsi </th>
                            <td class="px-8 py-6 text-left"> {{ $location->desc }} </td>
                        </tr>



                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- MODAL --}}
    <x-modal name="create-location" :show="false" focusable>

        <div class="p-8">

            <h2 class="text-2xl dark:text-slate-200 font-black mb-6">
                Tambah Lokasi
            </h2>

            <form action="{{ route('location.store') }}" method="post">
                @csrf
                @method('put')
                <div class="mb-4">
                    <x-input-label for="namaLokasi" :value="__('Nama Lokasi')" />
                    <x-text-input id="namaLokasi" class="block mt-1 w-full" type="text" name="namaLokasi"
                        :value="old('namaLokasi', $location->room_name)" required />
                    <x-input-error :messages="$errors->get('namaLokasi')" class="mt-2" />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="mb-4">
                        <x-input-label for="ukuran" :value="__('Ukuran Lokasi')" />

                        <div class="flex gap-4 mt-3">
                            @foreach (['small', 'medium', 'large'] as $size)
                                <label class="flex item-center gap-2">
                                    <input type="radio" name="ukuran" value="{{ $size }}" id="ukuran"
                                        {{ old('ukuran', $location->size) == $size ? 'checked' : '' }}
                                        class="border-slate-300 text-indigo-600 focus:ring-indigo-500">

                                    <span class="capitalize text-slate-200">
                                        {{ $size }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <x-input-error :messages="$errors->get('ukuran')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="availability" :value="__('Ruangan Tersedia')" />
                        <label for="availability" class="flex items-center gap-2 mt-3 cursor-pointer">
                            <input type="hidden" name="availability" value="0">
                            <input type="checkbox" name="availability" id="availability" value="1"
                                {{ old('availability', $location->isAvailable) ? 'checked' : '' }}
                                class="w-4 h-4 rounded text-emerald-500 border-slate-300 focus:ring-emerald-500">

                            <span class="text-sm text-slate-600 dark:text-slate-300">Tersedia</span>
                        </label>
                        <x-input-error :messages="$errors->get('availability')" class="mt-2" />
                    </div>
                </div>


                <div class="mb-4">
                    <x-input-label for="deksripsi" :value="__('Deskripsi Lokasi')" />
                    <textarea name="deskripsi" id="deskripsi"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"> {{ $location->desc }} </textarea>
                    <x-input-error :messages="$errors->get('deksripsi')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold text-sm">Tambah
                        Lokasi</button>
                </div>




            </form>



        </div>

    </x-modal>

</x-app-layout>
