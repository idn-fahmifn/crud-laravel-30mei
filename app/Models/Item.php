<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'uuid', 'item_name', 'location_id', 'category', 'status', 'desc'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

}
