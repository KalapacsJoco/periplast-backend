<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ErrorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'solution',
        'fixed_at',
        'stopped_at',
        'resumed_at'
    ];

    protected $casts = [
        'fixed_at' => 'datetime',
        'stopped_at' => 'datetime',
        'resumed_at' => 'datetime',
    ];

    const STATUS_ACTUAL = 'actual';
    const STATUS_FIXED = 'fixed';
    const STATUS_STOPPED = 'stopped';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_ACTUAL,
            self::STATUS_FIXED,
            self::STATUS_STOPPED,
        ];
    }

    // Relationship to get all machines that have this error log
    public function machines(): MorphToMany
    {
        return $this->morphedByMany(Machine::class, 'error_loggable');
    }

    // Relationship to get all tools that have this error log
    public function tools(): MorphToMany
    {
        return $this->morphedByMany(Tool::class, 'error_loggable');
    }

    // Scope for actual errors
    public function scopeActual($query)
    {
        return $query->where('status', self::STATUS_ACTUAL);
    }

    // Scope for fixed errors
    public function scopeFixed($query)
    {
        return $query->where('status', self::STATUS_FIXED);
    }

    // Scope for stopped errors
    public function scopeStopped($query)
    {
        return $query->where('status', self::STATUS_STOPPED);
    }

    // Helper method to mark error as stopped
    public function markAsStopped(): void
    {
        $this->update([
            'status' => self::STATUS_STOPPED,
            'stopped_at' => now(),
            'resumed_at' => null,
        ]);
    }

    // Helper method to resume from stopped state
    public function markAsResumed(): void
    {
        $this->update([
            'status' => self::STATUS_ACTUAL,
            'resumed_at' => now(),
        ]);
    }

    // Helper method to check if error is stopped
    public function isStopped(): bool
    {
        return $this->status === self::STATUS_STOPPED;
    }

    // Helper method to get downtime duration
    public function getDowntimeDuration(): ?string
    {
        if ($this->stopped_at && $this->resumed_at) {
            $diff = $this->stopped_at->diff($this->resumed_at);
            return $diff->format('%H:%I:%S');
        }

        if ($this->stopped_at) {
            $diff = $this->stopped_at->diff(now());
            return $diff->format('%H:%I:%S');
        }

        return null;
    }

    // Helper method to mark error as fixed
    public function markAsFixed(?string $solution = null): void
    {
        $this->update([
            'status' => self::STATUS_FIXED,
            'solution' => $solution,
            'fixed_at' => now(),
        ]);
    }

    // Helper method to check if error is fixed
    public function isFixed(): bool
    {
        return $this->status === self::STATUS_FIXED;
    }

    // Helper method to check if error is actual
    public function isActual(): bool
    {
        return $this->status === self::STATUS_ACTUAL;
    }
}
