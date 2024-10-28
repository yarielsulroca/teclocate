<?php

namespace App\Http\Controllers;

use App\Exports\ClientesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\ClientsImport;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{

    public function import(Request $request)
    {
        try {
            $file = $request->file('import_file');
            if (!$file) {
                throw new \Exception('No file uploaded');
            }

            Excel::import(new ClientsImport, $file);
            return response()->json(['message' => 'Clientes importados con éxito.'], 200);
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

        public function export()
        {
            return Excel::download(new ClientesExport, 'clientes.xlsx');
        }
}
