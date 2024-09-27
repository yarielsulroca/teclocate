<?php

namespace App\Http\Controllers\Api;

use App\Models\Visita;
use Illuminate\Http\Request;
use App\Http\Requests\VisitaRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\VisitaResource;

class VisitaApiController extends Controller
{

    public function index(Request $request)
    {
        $visitas = Visita::paginate();

        return VisitaResource::collection($visitas);
    }

    public function store(VisitaRequest $request)
    {
        try {
            $visita = Visita::create([
                'ticket_id' => $request->ticket_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'comenzada' => $request->comenzada,
                'terminada' => $request->terminada,
            ]);

            return response()->json(['message' => 'Visita creada exitosamente', 'data' => $visita], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la visita: ' . $e->getMessage()], 400);
        }
    }

    public function show(Visita $visita): Visita
    {
        return $visita;
    }
    public function update(Request $request, $id)
    {
        // Validar los datos de la solicitud
        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'comenzada' => 'required|boolean',
            'terminada' => 'nullable|boolean',
        ]);

        try {
            // Encontrar la visita por ID
            $visita = Visita::findOrFail($id);

            // Actualizar los datos de la visita
            $visita->update($validatedData);

            return response()->json([
                'message' => 'Visita actualizada correctamente',
                'visita' => $visita
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la visita',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function visitasEnd($phone){
        $visitas = Visita::join('tickets', 'visitas.ticket_id', '=', 'tickets.id')
        ->join('tecnicos', 'tickets.tecnico_id', '=', 'tecnicos.id')
        ->where('tecnicos.phone', $phone)
        ->where('visitas.terminada', false)
        ->select('visitas.*')->get();
        if(!$visitas){
        return response()->json(['message' => 'No tienes Visitas Por Finalizar'],400);
        }
        return response()->json(['message' => 'Vsisitas por Finalizar','visitas'=>$visitas],201);
        }
}
