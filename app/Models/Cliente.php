<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visita;
use App\Models\Tecnico;
use App\Models\Ticket;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nro_cliente',
        'razon_social',
        'descripcion',
        'calle',
        'numero',
        'localidad',
        'provincia',
        'pais',
        'latitud',
        'longitud',
        'horario_inicio',
        'horario_fin',
        'tiempo_servicio',
        'tipo',
        'grupo_vendedor',
        'direccion_detalle',
        'phone',
        'correo',

    ];
    public function visitas(){
        return $this->hasMany(Visita::class);
    }
    public function tecnicos()
    {
        return $this->belongsToMany(Tecnico::class, 'cliente_tecnico');
    }
    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

}
