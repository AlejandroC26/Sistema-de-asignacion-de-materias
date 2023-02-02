<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaturaEstudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_estudiante',
        'id_asignatura_profesor'
    ];


    public $table = "asignatura_estudiante";
}
