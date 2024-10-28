<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visita;
use App\Models\Tecnico;
use App\Models\Cliente;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'nro_ticket',
        'descripcion',
        'tecnico_id',
        'terminado',
        'prioridad',
        'fecha_asignacion',
        'fecha_solucion',
        'estado',
    ];
    public function visita()
    {
        return $this->hasOne(Visita::class);
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function tecnico(){
        return $this->belongsTo(Tecnico::class);
    }
}

