<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Visita
 *
 * @property $id
 * @property $ticket_id
 * @property $latitude
 * @property $longitude
 * @property $comenzada
 * @property $terminada
 * @property $created_at
 * @property $updated_at
 *
 * @property Visita $visita
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Visita extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['ticket_id', 'latitude', 'longitude', 'comenzada', 'terminada'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(\App\Models\Ticket::class, 'ticket_id', 'id');
    }

}
