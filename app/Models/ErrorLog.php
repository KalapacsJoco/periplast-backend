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
        'fixed_at'
    ];

    protected $casts = [
        'fixed_at' => 'datetime',
    ];

    const STATUS_ACTUAL = 'actual';
    const STATUS_FIXED = 'fixed';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_ACTUAL,
            self::STATUS_FIXED,
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
