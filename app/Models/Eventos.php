<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    use HasFactory;

    protected $primaryKey = 'eve_id';
    protected $table = "eventos";
    protected $fillable = ["eve_nombre", "eve_completado"];

    public function participantes()
    {
        return $this->hasMany(Participantes::class, 'par_eve_id', 'eve_id');
    }
}
