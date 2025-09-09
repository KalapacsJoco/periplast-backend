<?php

namespace App\Filament\Resources\Machines\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MachinesTable
{
    public static function configure(Table $table): Table
    {
         return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Gépnév')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('brand')
                    ->label('Márka')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('type')
                    ->label('Típus')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('screw_diameter')
                    ->label('Csavar átmérő (mm)')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => $state ? $state . ' mm' : '-'),
                
                BadgeColumn::make('status')
                    ->label('Állapot')
                    ->colors([
                        'success' => 'available',
                        'primary' => 'working',
                        'warning' => 'warning',
                        'danger' => 'stopped',
                        'gray' => 'under_setup',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'available' => 'Elérhető',
                        'working' => 'Dolgozik',
                        'warning' => 'Figyelmeztetés',
                        'stopped' => 'Leállítva',
                        'under_setup' => 'Beállítás alatt',
                        default => $state,
                    }),
                
                TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime('Y.m.d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Frissítve')
                    ->dateTime('Y.m.d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
