<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaMateria extends Model
{
    use HasFactory;

    protected $table = 'persona_materia';
    protected $primaryKey = 'idpersona_materia';
    public $timestamps = false;

    protected $fillable = [
        'persona_idpersona',
        'materia_idmateria',
        'activo'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_idpersona', 'idpersona');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_idmateria', 'idmateria');
    }
}