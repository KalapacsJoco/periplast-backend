<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
