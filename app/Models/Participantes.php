<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participantes extends Model
{
    use HasFactory;

    protected $primaryKey = 'par_id';
    protected $table = "participantes";
    protected $fillable = ["par_eve_id", "par_equ_id", "par_minutos", "par_segundos"];
}
