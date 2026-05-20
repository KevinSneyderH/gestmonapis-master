<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaCarrera extends Model
{
    use HasFactory;

    protected $table = 'persona_carrera';
    protected $primaryKey = 'idpersona_carrera';
    public $timestamps = false;

    protected $fillable = [
        'persona_idpersona',
        'carrera_idcarrera'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_idpersona', 'idpersona');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_idcarrera', 'idcarrera');
    }
}