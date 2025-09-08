<?php

namespace App\Enums;

enum MachineStatus: string
{
    case AVAILABLE = 'available';
    case WORKING = 'working';
    case WARNING = 'warning';
    case STOPPED = 'stopped';
    case UNDER_SETUP = 'under_setup';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Available',
            self::WORKING => 'Working',
            self::WARNING => 'Warning',
            self::STOPPED => 'Stopped',
            self::UNDER_SETUP => 'Under Setup',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::AVAILABLE => 'success',
            self::WORKING => 'primary',
            self::WARNING => 'warning',
            self::STOPPED => 'danger',
            self::UNDER_SETUP => 'info',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::AVAILABLE => 'check-circle',
            self::WORKING => 'play-circle',
            self::WARNING => 'exclamation-triangle',
            self::STOPPED => 'stop-circle',
            self::UNDER_SETUP => 'wrench',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::AVAILABLE->value => self::AVAILABLE->label(),
            self::WORKING->value => self::WORKING->label(),
            self::WARNING->value => self::WARNING->label(),
            self::STOPPED->value => self::STOPPED->label(),
            self::UNDER_SETUP->value => self::UNDER_SETUP->label(),
        ];
    }
}