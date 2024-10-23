<?php

use App\Models\Equipos;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id("equ_id");
            $table->string("equ_nombre");
            $table->timestamps();
        });

        $equipos = ["Asoprodespla", "Asoagricac", "ASOCOPROCADA", "ASOCOPROCADA - 2", "CAOCARES", "ACEFUVER", "ASOCPRAUR", "ASOCPRAUR - 2", "ASOPRONE", "TULANTIOQUIA", "NN", "NN"];

        foreach ($equipos as $equ) {
            $equipo = new Equipos();
            $equipo->equ_nombre = $equ;
            $equipo->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
