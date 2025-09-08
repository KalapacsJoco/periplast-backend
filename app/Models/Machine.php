<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Enums\MachineStatus; // Add this import

class Machine extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Add this cast to automatically convert the status to the enum
    protected $casts = [
        'status' => MachineStatus::class,
    ];

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

    // Add scope methods for filtering by status
    public function scopeAvailable($query)
    {
        return $query->where('status', MachineStatus::AVAILABLE->value);
    }

    public function scopeWorking($query)
    {
        return $query->where('status', MachineStatus::WORKING->value);
    }

    public function scopeWarning($query)
    {
        return $query->where('status', MachineStatus::WARNING->value);
    }

    public function scopeStopped($query)
    {
        return $query->where('status', MachineStatus::STOPPED->value);
    }

    public function scopeUnderSetup($query)
    {
        return $query->where('status', MachineStatus::UNDER_SETUP->value);
    }
}