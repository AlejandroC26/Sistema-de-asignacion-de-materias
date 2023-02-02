<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaturaProfesor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_profesor',
        'id_asignatura'
    ];

    public $table = "asignatura_profesor";
}
