<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';
    protected $primaryKey = 'idpersona';
    public $timestamps = false;

    protected $fillable = [
        'tipoDocumento',
        'numeroDocumento',
        'nombres',
        'apellidos',
        'email'
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'persona_idpersona', 'idpersona');
    }

    public function carreras()
    {
        return $this->hasMany(PersonaCarrera::class, 'persona_idpersona', 'idpersona');
    }

    // Add this relationship to your existing Persona model
    public function materias()
    {
        return $this->hasMany(PersonaMateria::class, 'persona_idpersona', 'idpersona');
    }
}