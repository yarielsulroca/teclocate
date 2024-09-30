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
    private function  calculateDistance($lat1, $lon1, $lat2, $lon2) {
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
    public function update(Request $request, $id) {
        try {
            $visita = Visita::find($id);
            if ($visita) {
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');

                // Validando distancias
                $distancia = $this->calculateDistance($visita->cliente->latitude, $visita->cliente->longitude, $latitude, $longitude);

                if ($distancia <= 50) {
                    $visita->ticket_id=$visita->ticket_id;
                    $visita->comenzada= true;
                    $visita->terminada = true;
                    $visita->latitude = $latitude;
                    $visita->longitude = $longitude;
                    $visita->save();

                    return response()->json([
                        'message' => 'Visita terminada correctamente',
                        'visita' => $visita,
                        'distancia' => $distancia
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Su distancia es mayor a 50 metros de las coordenadas de la visita',
                        'distancia' => $distancia
                    ], 400);
                }
            }

            return response()->json([
                'message' => 'No se encontró ninguna visita con ese ID',
                'id' => $id
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
