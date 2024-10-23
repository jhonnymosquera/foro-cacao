<?php

use App\Models\Equipos;
use App\Models\Participantes;
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
        Schema::create('participantes', function (Blueprint $table) {
            $table->id("par_id");
            $table->foreignId("par_eve_id")->references("eve_id")->on("eventos");
            $table->foreignId("par_equ_id")->references("equ_id")->on("equipos");
            $table->unsignedInteger("par_minutos")->default(0);
            $table->unsignedInteger("par_segundos")->default(0)->max(60);
            $table->timestamps();
        });

        for ($i = 1; $i <= 12; $i++) {
            $participante = new Participantes();
            $participante->par_eve_id = 1;
            $participante->par_equ_id = $i;
            $participante->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
