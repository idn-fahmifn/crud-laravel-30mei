<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'namaLokasi' => ['required', 'string', 'min:5', 'max:30'],
            'ukuran' => ['required', 'in:small,medium,large'],
            'availability' => ['required', 'in:1,0'],
            'deskripsi' => ['required'],
        ]);

        // array untuk menyimpan data ke model item
        $simpan = [
            'uuid' => Str::uuid(),
            'room_name' => $request->input('namaLokasi'),
            'size' => $request->input('ukuran'),
            'isAvailable' => $request->input('availability'),
            'desc' => $request->input('deskripsi'),
        ];

        Location::create($simpan);

        return redirect()->route('location.index')->with('success', 'Lokasi berhasil ditambahkan');
    }

    public function show($param)
    {
        $locations = Location::where('uuid', $param)->firstOrFail();
        return view('locations.show', [
            'location' => $locations,
        ]);
    }

    public function update(Request $request, $param)
    {

        $data = Location::where('uuid', $param)->firstOrFail();

        $request->validate([
            'namaLokasi' => ['required', 'string', 'min:5', 'max:30'],
            'ukuran' => ['required', 'in:small,medium,large'],
            'availability' => ['required', 'in:1,0'],
            'deskripsi' => ['required'],
        ]);

        // array untuk menyimpan data ke model item
        $simpan = [
            'uuid' => Str::uuid(),
            'room_name' => $request->input('namaLokasi'),
            'size' => $request->input('ukuran'),
            'isAvailable' => $request->input('availability'),
            'desc' => $request->input('deskripsi'),
        ];

        $data->update($simpan);

        return redirect()->route('location.show', $data->uuid)->with('success', 'Lokasi berhasil diubah');
    }

    public function delete($param)
    {
        $locations = Location::where('uuid', $param)->firstOrFail();
        $locations->delete();
        return redirect()->route('location.index')->with('success', 'Lokasi Berhasil dihapus');
    }
}
