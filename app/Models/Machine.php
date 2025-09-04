<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function maintenanceRecords()
    {
        return $this->morphMany(MaintenanceRecord::class, 'maintainable');
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'machine_tool')
            ->withTimestamps();
    }
}
