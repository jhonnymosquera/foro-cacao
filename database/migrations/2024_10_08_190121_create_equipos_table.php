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

        for ($i = 1; $i <= 12; $i++) {
            $equipo = new Equipos();
            $equipo->equ_nombre = "Equipos " . $i;
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
