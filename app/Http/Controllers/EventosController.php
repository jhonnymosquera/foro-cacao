<?php

namespace App\Http\Controllers;

use App\Models\Eventos;
use App\Models\Participantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pest\Mutate\Mutators\Sets\NumberSet;

class EventosController extends Controller
{
    public function completar(String $eve_id)
    {
        // obtenemos los participantes con tiempo registrado
        $participantes = Participantes::where('par_eve_id', $eve_id)
            ->where('par_minutos', '=', 0)
            ->where('par_segundos', '=', 0)
            ->get();

        // si hay participantes sin tiempo registrado, mostramos un mensaje de error
        if ($participantes->count() > 0) {
            return response()->json([
                'message' => 'Queda ' . $participantes->count() . ' equipos sin registrar tiempo',
                'icon' => 'error',
            ]);
        }

        // actualizamos el evento a completado
        DB::table('eventos')->where('eve_id', $eve_id)->update(['eve_completado' => true]);
        // obtenemos el id del evento siguiente
        $evento = Eventos::find($eve_id + 1);
        $id = $evento ? $evento->eve_id : $eve_id;

        //Vamos buscar los participantes con menor tiempo registrado y agregarlos al siguiente evento
        $totalParticipants = DB::table('participantes')
            ->where('par_eve_id', $eve_id)
            ->count();

        $halfCount = ceil($totalParticipants / 2);

        $resultado = DB::table('participantes')
            ->select('eventos.eve_id', 'eventos.eve_nombre', 'equipos.equ_id', 'equipos.equ_nombre', 'participantes.par_minutos', 'participantes.par_segundos')
            ->join('eventos', 'participantes.par_eve_id', '=', 'eventos.eve_id')
            ->join('equipos', 'participantes.par_equ_id', '=', 'equipos.equ_id')
            ->where('participantes.par_eve_id', $eve_id)
            ->orderBy(DB::raw('participantes.par_minutos * 60 + participantes.par_segundos'))
            ->limit($halfCount)
            ->get();

        // inscribimos al siguiente evento los participantes con menor tiempo registrado
        if ($eve_id < 3) {
            foreach ($resultado as $participante) {
                $newParticipante = new Participantes();
                $newParticipante->par_eve_id = $eve_id + 1;
                $newParticipante->par_equ_id = $participante->equ_id;
                $newParticipante->save();
            }
        }

        return response()->json([
            'message' => 'Evento completado',
            'icon' => 'success',
            'redirect' => route('participantes.index', $id),
        ]);
    }

    public function ver(String $eve_id)
    {
        if ($eve_id == 1) {
            return redirect()->route('participantes.index', 1);
        }

        $evento = Eventos::find($eve_id - 1);

        if (!$evento->eve_completado) {
            return back()->with([
                'message' => 'El evento anterior no ha sido completado',
                'icon' => 'error',
            ]);
        } else {
            return redirect()->route('participantes.index', $eve_id);
        }



        return redirect()->route('participantes.index', $evento->eve_id);
    }
}
