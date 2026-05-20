<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudAsesoria extends Model
{
    use HasFactory;

    protected $table = 'solicitud_asesoria';
    protected $primaryKey = 'idsolicitud_asesoria';
    public $timestamps = false;

    protected $fillable = [
        'persona_idpersona',
        'materia_idmateria',
        'fecha_inicio',
        'fecha_final',
        'estado'
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