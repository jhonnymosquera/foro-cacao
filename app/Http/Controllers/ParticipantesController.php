<?php

namespace App\Http\Controllers;

use App\Models\Eventos;
use App\Models\Participantes;
use Illuminate\Http\Request;


class ParticipantesController extends Controller
{
    public function index(String $eve_id)
    {
        $participantes = Participantes::join('eventos', 'eve_id', '=', 'par_eve_id')
            ->join('equipos', 'equipos.equ_id', '=', 'participantes.par_equ_id')
            ->where('eve_id', $eve_id)
            ->get();

        $evento = Eventos::find($eve_id);

        return view('participantes.index', compact('participantes', 'evento'));
    }

    public function update(Request $req, Participantes $participantes)
    {
        try {
            $minutos = $req->minutos;
            $segundos = $req->segundos;

            if ($segundos < 0) {
                return response()->json([
                    'icon' => 'error',
                    'message' => 'Los segundos deben ser mayores o iguales a 0',
                ]);
            }

            if ($segundos > 59) {
                return response()->json([
                    'icon' => 'error',
                    'message' => 'Los segundos deben ser menores o iguales a 59',
                ]);
            }

            if ($minutos  == 0 && $segundos == 0) {
                return response()->json([
                    'icon' => 'info',
                    'message' => 'No se ha registrado ningun tiempo',
                ]);
            }

            $participantes = Participantes::find($req->id);
            $participantes->par_minutos = $req->minutos;
            $participantes->par_segundos = $req->segundos;
            $participantes->save();


            return response()->json([
                'message' => 'Datos actualizados correctamente',
                'icon' => 'success',
                'redirect' => route('participantes.index', $participantes->par_eve_id),
            ]);
        } catch (\Error $error) {
            return response()->json(["icon" => "error", "message" => "Ups, algo salió mal"]);
        }
    }
}
