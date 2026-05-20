<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materia'; // Nombre de la tabla en la BD

    protected $primaryKey = 'idmateria'; // Clave primaria

    public $timestamps = true; // Habilita created_at y updated_at

    protected $fillable = ['nombre']; // Campos que se pueden asignar masivamente
}
