<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visita;
use App\Models\Cliente;
use App\Models\Ticket;

class Tecnico extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'phone',
        'email',
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $exists = Tecnico::where('nombre', $model->nombre)
                ->where('phone', $model->phone)
                ->exists();

            if ($exists) {
                throw new \Exception('El técnico con el mismo nombre y número de celular ya existe.');
            }
        });
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_tecnico');
    }


}
