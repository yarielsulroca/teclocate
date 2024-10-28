<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use App\Imports\ClientesImport;
use App\Exports\ClientesExport;
use Filament\Facades\Filament;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nro_cliente')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('razon_social')
                    ->maxLength(191),
                Forms\Components\Textarea::make('descripcion')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('calle')
                    ->maxLength(191),
                Forms\Components\TextInput::make('numero')
                    ->maxLength(191),
                Forms\Components\TextInput::make('localidad')
                    ->maxLength(191),
                Forms\Components\TextInput::make('provincia')
                    ->maxLength(191),
                Forms\Components\TextInput::make('pais')
                    ->maxLength(191),
                Forms\Components\TextInput::make('latitud')
                    ->numeric(),
                Forms\Components\TextInput::make('longitud')
                    ->numeric(),
                Forms\Components\TextInput::make('horario_inicio'),
                Forms\Components\TextInput::make('horario_fin'),
                Forms\Components\TextInput::make('tiempo_servicio')
                    ->numeric(),
                Forms\Components\TextInput::make('tipo')
                    ->maxLength(191),
                Forms\Components\TextInput::make('zona')
                    ->maxLength(191),
                Forms\Components\Textarea::make('direccion_detalle')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(191),
                Forms\Components\TextInput::make('correo')
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nro_cliente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('razon_social')
                    ->searchable(),
                Tables\Columns\TextColumn::make('calle')
                    ->searchable(),
                Tables\Columns\TextColumn::make('numero')
                    ->searchable(),
                Tables\Columns\TextColumn::make('localidad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provincia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pais')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitud')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitud')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('horario_inicio'),
                Tables\Columns\TextColumn::make('horario_fin'),
                Tables\Columns\TextColumn::make('tiempo_servicio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zona')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([/*
                Action::make('import')
                ->label('Importar Clientes')
                ->form([
                    FileUpload::make('file')->required(),
                ])
                ->action(function (array $data) {
                    // Verifica si $data['file'] es un objeto de archivo
                    if ($data['file'] instanceof \Illuminate\Http\UploadedFile) {
                        // Almacena el archivo en la carpeta 'public' dentro de 'storage/app'
                        $path = $data['file']->store('public');
                        Log::info('Archivo almacenado en: ' . $path);

                        // Obtiene la ruta completa del archivo
                        $fullPath = Storage::path($path);
                        Log::info('Ruta completa del archivo: ' . $fullPath);

                        // Verifica si el archivo existe
                        if (file_exists($fullPath)) {
                            try {
                                Excel::import(new ClientesImport, $fullPath);
                                Notification::make()
                                    ->title('Clientes importados exitosamente.')
                                    ->success()
                                    ->send();
                            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                                $failures = $e->failures();
                                Notification::make()
                                    ->title('Error de validación en el archivo.')
                                    ->danger()
                                    ->send();
                            } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
                                Notification::make()
                                    ->title('Archivo no encontrado.')
                                    ->danger()
                                    ->send();
                            } catch (\Exception $e) {
                                Log::error('Error al importar el archivo: ' . $e->getMessage());
                                Notification::make()
                                    ->title('Ocurrió un error inesperado: ' . $e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        } else {
                            Log::error('Archivo no encontrado en la ruta: ' . $fullPath);
                            Notification::make()
                                ->title('Archivo no encontrado en el almacenamiento.')
                                ->danger()
                                ->send();
                        }
                    } else {
                        Log::error('El archivo no es una instancia de UploadedFile.');
                        Notification::make()
                            ->title('Error al cargar el archivo.')
                            ->danger()
                            ->send();
                    }
                }), */
            Action::make('export')
                ->label('Exportar Clientes')
                ->action(function () {
                    return Excel::download(new ClientesExport, 'clientes.xlsx');
                }),
            Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])->button(),
            ]);
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
