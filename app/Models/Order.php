<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => 'string', // Simple string casting
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
