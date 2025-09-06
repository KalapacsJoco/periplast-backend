<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    public function errorLogs(): MorphToMany
    {
        return $this->morphToMany(ErrorLog::class, 'error_loggable');
    }

    // Get only actual errors
    public function actualErrorLogs(): MorphToMany
    {
        return $this->errorLogs()->where('status', ErrorLog::STATUS_ACTUAL);
    }

    // Get only fixed errors
    public function fixedErrorLogs(): MorphToMany
    {
        return $this->errorLogs()->where('status', ErrorLog::STATUS_FIXED);
    }
}
