<?php

use App\Models\Eventos;
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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id("eve_id");
            $table->string("eve_nombre");
            $table->boolean("eve_completado")->default(false);
            $table->timestamps();
        });

        for ($i = 1; $i <= 3; $i++) {
            $evento = new Eventos();
            $evento->eve_nombre = "Evento " . $i;
            $evento->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
