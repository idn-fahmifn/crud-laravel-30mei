<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-black text-2xl text-slate-800 dark:text-white">
                    Data Lokasi
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Management lokasi inventory
                </p>

            </div>

            <button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'create-location')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold text-sm">

                + Tambah Lokasi

            </button>

        </div>

    </x-slot>

    <div class="py-10 bg-[#F8FAFC] dark:bg-slate-950 min-h-screen">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERT --}}
            <div
                x-data="{ show: true }"
                x-show="show"
                class="mb-6 flex items-center justify-between bg-blue-100 border border-blue-300 text-blue-700 px-6 py-4 rounded-2xl">

                <span class="font-semibold">
                    Lokasi berhasil dibuat
                </span>

                <button @click="show = false">
                    ✕
                </button>

            </div>

            {{-- TABLE --}}
            <div class="bg-white dark:bg-slate-700 rounded-md overflow-hidden">

                <table class="w-full">

                    <thead class="bg-slate-200 dark:bg-slate-800">

                        <tr class="text-xs uppercase tracking-[0.2em] text-slate-600 dark:text-slate-200">

                            <th class="px-8 py-5 text-left">Nama Lokasi</th>
                            <th class="px-8 py-5 text-left">Ukuran</th>
                            <th class="px-8 py-5 text-left">Status</th>
                            <th class="px-8 py-5 text-left">Pilihan</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr class="text-slate-600 dark:text-slate-300"">

                            <td class="px-8 py-6">Gedung Utama</td>
                            <td class="px-8 py-6 font-bold">large</td>
                            <td class="px-8 py-6 text-emerald-500 font-bold">
                                Available
                            </td>
                            <td>
                                <a href="" class="px-8 py-6 font-bold text-blue-500">Detail</a>
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- MODAL --}}
    <x-modal name="create-location" :show="false" focusable>

        <div class="p-8">

            <h2 class="text-2xl font-black mb-6">
                Tambah Lokasi
            </h2>

            <form class="space-y-5">

                <div>

                    <x-input-label value="Nama Lokasi" />

                    <x-text-input
                        type="text"
                        class="mt-2 block w-full rounded-2xl" />

                </div>

                <div>

                    <x-input-label value="Ukuran" />

                    <select class="mt-2 block w-full rounded-2xl border-slate-300">

                        <option>Small</option>
                        <option>Medium</option>
                        <option>Large</option>

                    </select>

                </div>

                <div>

                    <x-input-label value="Status" />

                    <select class="mt-2 block w-full rounded-2xl border-slate-300">

                        <option>Available</option>
                        <option>Close</option>
                        <option>Full</option>
                        <option>Maintenance</option>

                    </select>

                </div>

                <div>

                    <x-input-label value="Layout Image" />

                    <x-text-input
                        type="file"
                        class="mt-2 block w-full rounded-2xl" />

                </div>

                <div>

                    <x-input-label value="Deskripsi" />

                    <textarea
                        rows="4"
                        class="mt-2 block w-full rounded-2xl border-slate-300"></textarea>

                </div>

                <div class="flex justify-end gap-3 pt-5">

                    <button
                        type="button"
                        x-on:click="$dispatch('close')"
                        class="px-6 py-3 rounded-2xl text-slate-500 hover:bg-slate-100">

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-bold">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </x-modal>

</x-app-layout>