<?php

namespace App\Imports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class ClientsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Cliente([
    'nro_cliente'=>     $row['nro_cliente'],
    'razon_social'=>    $row['razon_social'],
    'descripcion'=>     $row['descripcion'],
    'calle'=>           $row['calle'],
    'numero'=>          $row['numero'],
    'localidad'=>       $row['localidad'],
    'provincia'=>       $row['provincia'],
    'pais'=>            $row['pais'],
    'latitud'=>         $row['latitud'],
    'longitud'=>        $row['longitud'],
    'horario_inicio'=>  $row['horario_inicio'],
    'horario_fin'=>     $row['horario_fin'],
    'tiempo_servicio'=> $row['tiempo_servicio'],
    'tipo'=>            $row['tipo'],
    'zona'=>            $row['zona'],
    'direccion_detalle'=>$row['direccion_detalle'],
    'phone'=>           $row['phone'],
    'correo'=>          $row['correo'],
]);
    }
}
