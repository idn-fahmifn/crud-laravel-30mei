<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\{Item, Location};

class ItemController extends Controller
{
    public function index()
    {
        $locations = Location::where('isAvailable', true)->get();
        $items = Item::paginate(10);

        return view('items.index', [
            'items' => $items,
            'locations' => $locations,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaBarang' => ['required', 'string', 'min:5', 'max:30'],
            'namaLokasi' => ['required', 'exists:locations,id'],
            'status' => ['required', 'in:good,broke,maintenance'],
            'category' => ['required', 'in:makanan,elektronik,atk,logistik,lainnya'],
            'gambarBarang' => ['required', 'file', 'mimes:png,jpg,jpeg,svg,webp'],
            'deskripsi' => ['required'],
        ]);

        // array untuk menyimpan data ke model item
        $simpan = [
            'uuid' => Str::uuid(),
            'item_name' => $request->input('namaBarang'),
            'location_id' => $request->input('namaLokasi'),
            'category' => $request->input('category'),
            'status' => $request->input('status'),
            'desc' => $request->input('deskripsi'),
        ];

        if ($request->hasFile('gambarBarang')) {
            $gambar = $request->file('gambarBarang');
            $path = 'public/images/items';
            $nama = 'item_'.Carbon::now('asia/jakarta')->format('Ymdhis').random_int(000, 999).'.'.$gambar->getClientOriginalExtension();
            $simpan['image'] = $nama;
            $gambar->storeAs($path, $nama);
        }

        Item::create($simpan);

        return redirect()->route('item.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function show($param)
    {
        $items = Item::where('uuid', $param)->firstOrFail();
        $locations = Location::where('isAvailable', true)->get();

        return view('items.show', [
            'item' => $items,
            'locations' => $locations,
        ]);
    }

    public function update(Request $request, $param)
    {

        $data = Item::where('uuid', $param)->firstOrFail();
        $request->validate([
            'namaBarang' => ['required', 'string', 'min:5', 'max:30'],
            'namaLokasi' => ['required', 'exists:locations,id'],
            'status' => ['required', 'in:good,broke,maintenance'],
            'category' => ['required', 'in:makanan,elektronik,atk,logistik,lainnya'],
            'gambarBarang' => ['file', 'mimes:png,jpg,jpeg,svg,webp'],
            'deskripsi' => ['required'],
        ]);

        // array untuk menyimpan data ke model item
        $simpan = [
            'uuid' => Str::uuid(),
            'item_name' => $request->input('namaBarang'),
            'location_id' => $request->input('namaLokasi'),
            'category' => $request->input('category'),
            'status' => $request->input('status'),
            'desc' => $request->input('deskripsi'),
        ];

        if ($request->hasFile('gambarBarang')) {

            $path_lama = 'public/images/items/'.$data->image;

            if ($data->image && Storage::exists($path_lama)) {
                Storage::delete($path_lama);
            }

            $gambar = $request->file('gambarBarang');
            $path = 'public/images/items';
            $nama = 'item_'.Carbon::now('asia/jakarta')->format('Ymdhis').random_int(000, 999).'.'.$gambar->getClientOriginalExtension();
            $simpan['image'] = $nama;
            $gambar->storeAs($path, $nama);
        }

        $data->update($simpan);

        return redirect()->route('item.index')->with('success', 'Barang berhasil ditambahkan');

    }

    public function delete($param)
    {
        $locations = Location::where('uuid', $param)->firstOrFail();
        $locations->delete();

        return redirect()->route('location.index')->with('success', 'Lokasi Berhasil dihapus');
    }
}
