<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    protected $guarded = [];

    public function machines()
    {
        return $this->morphedByMany(Machine::class, 'maintainable');
    }

    public function tools()
    {
        return $this->morphedByMany(Tool::class, 'maintainable');
    }

    public function inserts()
    {
        return $this->morphedByMany(Insert::class, 'maintainable');
    }
}
