<?php

use App\Http\Controllers\EventosController;
use App\Http\Controllers\ParticipantesController;
use App\Models\Eventos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('participantes.index', 1);
});

Route::get('/participantes/{eve_id}', [ParticipantesController::class, 'index'])->name('participantes.index');
Route::put('/participantes/{id}', [ParticipantesController::class, 'update'])->name('participantes.update');

Route::post('/eventos/completar/{eve_id}', [EventosController::class, 'completar'])->name('eventos.completar');
Route::post('/eventos/{eve_id}', [EventosController::class, 'ver'])->name('eventos.ver');


Route::view('/resultados', 'resultados.index')->name('resultados.index');
Route::get('/resultados/eventos', function () {

    $resultados = Eventos::select('eventos.eve_id', 'eventos.eve_nombre')
        ->join('participantes', 'eventos.eve_id', '=', 'participantes.par_eve_id')
        ->join('equipos', 'participantes.par_equ_id', '=', 'equipos.equ_id')
        ->select(
            'eventos.eve_id',
            'eventos.eve_nombre',
            'equipos.equ_id',
            'equipos.equ_nombre',
            'participantes.par_minutos',
            'participantes.par_segundos',
            DB::raw('(participantes.par_minutos * 60 + participantes.par_segundos) as tiempo_total')
        )
        ->where(function ($query) {
            $query->where('participantes.par_minutos', '>', 0)
                ->orWhere('participantes.par_segundos', '>', 0);
        })
        ->orderBy('eventos.eve_id')
        ->orderBy('tiempo_total')
        ->get()
        ->groupBy('eve_id')
        ->map(function ($grupo) {
            $primerEvento = $grupo->first();
            return [
                'evento_id' => $primerEvento->eve_id,
                'evento_nombre' => $primerEvento->eve_nombre,
                'equipos' => $grupo->map(function ($item) {
                    return [
                        'equipo_id' => $item->equ_id,
                        'equipo_nombre' => $item->equ_nombre,
                        'tiempo' => sprintf('%d:%02d', $item->par_minutos, $item->par_segundos)
                    ];
                })->values()->toArray()
            ];
        })->values()->toArray();



    return $resultados;
})->name('resultados.eventos');
