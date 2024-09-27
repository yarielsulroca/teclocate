<?php

namespace App\Imports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            return new Cliente([
                'id'=>$row[0],
                'nro_cliente' => $row[1],
                'razon_social' => $row[2],
                'descripcion' => $row[3],
                'calle' => $row[4],
                'numero' => $row[5],
                'localidad' => $row[6],
                'provincia' => $row[7],
                'pais' => $row[8],
                'latitud' => $row[9],
                'longitud' => $row[10],
                'horario_inicio' => $row[11],
                'horario_fin' => $row[12],
                'tiempo_servicio' => $row[13],
                'tipo' => $row[14],
                'zona' => $row[15],
                'direccion_detalle' => $row[16],
                'phone' => $row[17],
                'correo' => $row[18],

        ]);
    }
}
