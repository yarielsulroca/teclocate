<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TickectResource\Pages;
use App\Filament\Resources\TickectResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TickectResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('nro_ticket')
                ->required(),
                Forms\Components\Select::make('cliente_id')
                    ->label('Cliente')
                    ->options(function () {
                        return \App\Models\Cliente::all()->pluck('razon_social', 'id');
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\Textarea::make('descripcion')->required(),
                Forms\Components\Select::make('tecnico_id')
                    ->label('Técnico')
                    ->options(function () {
                        return \App\Models\Tecnico::all()->pluck('nombre', 'id');
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('prioridad')
                    ->options([
                        'alta' => 'Alta',
                        'media' => 'Media',
                        'baja' => 'Baja',
                    ])->required(),
                Forms\Components\DatePicker::make('fecha_asignacion')
                ->required(),
                Forms\Components\Select::make('estado')
                    ->options([
                        'abierto' => 'Abierto',
                        'Cerrado' => 'Cerrado',
                            ])
                    ->default('abierto')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('nro_ticket')
                ->label('# Ticket')
                ->toggleable()
                ->searchable(),
            Tables\Columns\TextColumn::make('cliente.razon_social')
                ->label('Cliente')
                ->toggleable()
                ->searchable(),
            Tables\Columns\TextColumn::make('cliente.nro_cliente')
                ->label('Nro Cliente')
                ->toggleable()
                ->searchable(),
            Tables\Columns\TextColumn::make('descripcion')
                ->toggleable()
                ->searchable(),
            Tables\Columns\TextColumn::make('tecnico.nombre')
                ->label('Técnico')
                ->toggleable()
                ->searchable(),
            Tables\Columns\TextColumn::make('prioridad')
                ->toggleable()
                ->searchable(),
            Tables\Columns\TextColumn::make('fecha_asignacion')
                ->toggleable()
                ->searchable(),
            Tables\Columns\TextColumn::make('estado')
                ->toggleable()
                ->searchable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('cliente_id')
                ->label('Cliente')
                ->relationship('cliente', 'razon_social'),
            Tables\Filters\SelectFilter::make('tecnico_id')
                ->label('Técnico')
                ->relationship('tecnico', 'nombre'),
            Tables\Filters\SelectFilter::make('estado')
                ->options([
                    'abierto' => 'Abierto',
                    'cerrado' => 'Cerrado',
                ]),
            Tables\Filters\SelectFilter::make('prioridad')
                ->options([
                    'alta' => 'Alta',
                    'media' => 'Media',
                    'baja' => 'Baja',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}

    public static function getRelations(): array
{
    return [

    ];
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickects::route('/'),
            'create' => Pages\CreateTickect::route('/create'),
            'edit' => Pages\EditTickect::route('/{record}/edit'),
        ];
    }
}
