<?php

namespace App\Filament\Resources\Machines;

use App\Filament\Resources\Machines\Pages\CreateMachine;
use App\Filament\Resources\Machines\Pages\EditMachine;
use App\Filament\Resources\Machines\Pages\ListMachines;
use App\Filament\Resources\Machines\Pages\ViewMachine;
use App\Filament\Resources\Machines\Schemas\MachineForm;
use App\Filament\Resources\Machines\Schemas\MachineInfolist;
use App\Filament\Resources\Machines\Tables\MachinesTable;
use App\Models\Machine;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MachineResource extends Resource
{
    protected static ?string $model = Machine::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('brand')
                    ->maxLength(255),
                
                TextInput::make('type')
                    ->maxLength(255),
                
                TextInput::make('screw_diameter')
                    ->numeric()
                    ->integer(),
                
                Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'working' => 'In Use',
                        'warning' => 'Warning',
                        'under_setup' => 'Under Setup',
                        'stopped' => 'Stopped',
                    ])
                    ->required()
                    ->default('available'),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MachineInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MachinesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMachines::route('/'),
            'create' => CreateMachine::route('/create'),
            'view' => ViewMachine::route('/{record}'),
            'edit' => EditMachine::route('/{record}/edit'),
        ];
    }
}
