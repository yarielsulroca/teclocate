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
 * @property $long_innit
 * @property $long_end
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
    public function  calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $R = 6371000; // Radio de la Tierra en metros
        $φ1 = deg2rad($lat1);
        $φ2 = deg2rad($lat2);
        $Δφ = deg2rad($lat2 - $lat1);
        $Δλ = deg2rad($lon2 - $lon1);

        $a = sin($Δφ / 2) * sin($Δφ / 2) +
            cos($φ1) * cos($φ2) *
            sin($Δλ / 2) * sin($Δλ / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c;
    }

}
