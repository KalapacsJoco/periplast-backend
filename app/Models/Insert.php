<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insert extends Model
{
    protected $guarded = [];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function maintenanceRecords()
    {
        return $this->morphMany(MaintenanceRecord::class, 'maintainable');
    }
}
