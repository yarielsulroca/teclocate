<?php

namespace App\Http\Controllers;

use App\Imports\ClientesImport;
use App\Exports\ClientesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    public function import (Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx',
    ]);

    $file = $request->file('file');

    if ($file->isValid()) {
        // Almacena el archivo en la carpeta 'public' dentro de 'storage/app'
        $path = $file->store('public');

        // Obtiene la ruta completa del archivo
        $fullPath = Storage::path($path);

        if (file_exists($fullPath)) {
            try {
                Excel::import(new ClientesImport, $fullPath);
                return redirect()->back()->with('success', 'Clientes importados exitosamente.');
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();
                return redirect()->back()->with('error', 'Error de validación en el archivo.')->with('failures', $failures);
            } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
                return redirect()->back()->with('error', 'Archivo no encontrado.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Archivo no encontrado en el almacenamiento.');
        }
    }

    return redirect()->back()->with('error', 'Error al cargar el archivo.');
}

    public function export()
    {
        return Excel::download(new ClientesExport, 'clientes.xlsx');
    }
}