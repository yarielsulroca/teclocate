<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitaResource\Pages;
use App\Filament\Resources\VisitaResource\Pages\EditVisita;
use App\Filament\Resources\VisitaResource\RelationManagers;
use App\Models\Ticket;
use App\Models\Visita;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;

class VisitaResource extends Resource
{
    protected static ?string $model = Visita::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('ticket_id')
                    ->label('Ticket')
                    ->options(function () {
                        return Ticket::where('estado', 'abierto')->pluck('nro_ticket', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $ticket = Ticket::find($state);
                        $set('cliente_razon_social', $ticket?->cliente->razon_social ?? 'Sin cliente');
                        $set('tecnico_nombre', $ticket?->tecnico->nombre ?? 'Sin técnico');
                        $set('tecnico_phone', $ticket?->tecnico->phone ?? 'Sin teléfono');
                        $set('tecnico_id', $ticket?->tecnico->id ?? null); // Set tecnico_id
                    }),

                TextInput::make('cliente_razon_social')
                    ->label('Cliente')
                    ->disabled(),

                TextInput::make('tecnico_nombre')
                    ->label('Técnico')
                    ->disabled(),

                TextInput::make('tecnico_phone')
                    ->label('Teléfono del Técnico')
                    ->disabled(),

                    TextInput::make('ticket_id')
                    ->label('Id del Tikets') // Add hidden field for tecnico_id
                    ->required(),

                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->numeric(),

                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->numeric(),

                Forms\Components\Toggle::make('comenzada')
                    ->required()
                    ->default(true),

                Forms\Components\Toggle::make('terminada')
                    ->required()
                    ->default(false),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('ticket.nro_ticket')
            ->label('Nº Ticket')
            ->searchable()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('ticket.estado')
                ->label('Estado Ticket')
                ->sortable()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),

            IconColumn::make('comenzada')
            ->label('Visita Comenzada')
            ->searchable()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->boolean(),

            IconColumn::make('terminada')
            ->label('Visita Terminada')
            ->searchable()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->boolean(),
            TextColumn::make('latitude')
                ->label('Latitud')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('longitude')
                ->label('Longitud')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                ->label('Iniciada')
                ->sortable()
                ->dateTime('d/m/Y H:i')
                ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                ->label('Terminada')
                ->sortable()
                ->searchable()
                ->dateTime('d/m/Y H:i')
                ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('ticket.tecnico.nombre')
                ->label('Nombre del Técnico')
                ->sortable()
                ->searchable()
                ->getStateUsing(fn ($record) => $record->ticket->tecnico->nombre ?? 'N/A'),

            TextColumn::make('ticket.tecnico.phone')
                ->label('Teléfono del Técnico')
                ->sortable()
                ->searchable()
                ->getStateUsing(fn ($record) => $record->ticket->tecnico->phone ?? 'N/A'),

                ])
                ->filters([

                ])
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListVisitas::route('/'),
            'create' => Pages\CreateVisita::route('/create'),
            'edit' => Pages\EditVisita::route('/{record}/edit'),
        ];
    }

}
