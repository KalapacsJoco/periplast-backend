<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $guarded = [];

    public function machines()
    {
        return $this->belongsToMany(Machine::class, 'machine_tool')
            ->withTimestamps();
    }

    public function maintenanceRecords()
    {
        return $this->morphMany(MaintenanceRecord::class, 'maintainable');
    }

    public function inserts()
    {
        return $this->hasMany(Insert::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
