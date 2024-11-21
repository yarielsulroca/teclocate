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
    
        $distance = $visita->calculateDistance($la1, $lo1, $la2, $lo2);
        try {
            $visita = Visita::create([
                'ticket_id' => $request->ticket_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'comenzada' => $request->comenzada,
                'terminada' => $request->terminada
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
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        if($latitude!==null && $longitude!==null)
            {
                $visita= Visita::find($id);
                    if($visita){
                        $la1= $latitude;
                        $lo1= $longitude;
                        $la2= $visita->ticket->cliente->latitud;
                        $lo2= $visita->ticket->cliente->longitud;
                        $distance = $visita->calculateDistance($la1, $lo1, $la2, $lo2);
                        $visita->update([
                            'comenzada' => true,
                            'terminada' => true,
                            'latitude' => $latitude,
                            'longitude' => $longitude,
                            'long_end' => $distance
                        ]);
                        $visita->save();
                        return response()->json([
                            'visita'=> $visita,
                            'message'=>'La visita fue Finalizada',
                            'distance'=>$distance],
                            200);
                    }
                    return response()->json([
                        'id'=> $id,
                        'message'=>'No se encontro Visita'],
                        400);
            }
        return response()->json(['message'=> 'La latitud y longitud pasadas son null'],400);
            }
}
