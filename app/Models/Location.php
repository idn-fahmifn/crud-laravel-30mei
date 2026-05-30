<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'uuid', 'room_name', 'size', 'isAvailable','desc'
    ];

    // relasi one to many ke model item = 1 ruangan memiliki banyak barang
    public function item()
    {
        return $this->hasMany(Item::class, 'location_id');
    }
}
