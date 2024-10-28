<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($phone)
    {
        $tickets = Ticket::with(['visita', 'cliente', 'tecnico'])
        ->whereHas('tecnico', function ($query) use ($phone) {
            $query->where('phone', $phone);
        })
        ->get()
        ->filter(function ($ticket) {
            return $ticket->visita === null; // Filtra tickets donde visita es null
        });

    if ($tickets->isEmpty()) {
        return response()->json([
            'error' => 'No hay tickets para usted.',
        ], 404);
    }

    return response()->json($tickets->values());
    }
    public function update ($phone)
    {
        $tickets = Ticket::with(['visita', 'cliente', 'tecnico'])
            ->whereHas('tecnico', function ($query) use ($phone) {
                $query->where('phone', $phone);
            })
            ->get()
            ->filter(function ($ticket) {
                return $ticket->visita != null; // Filtra tickets donde visitatenga parametros
            });

        if ($tickets->isEmpty()) {
            return response()->json([
                'error' => 'No tiene tickets a finalizar.',
            ], 404);
        }

        return response()->json($tickets);
    }

}
