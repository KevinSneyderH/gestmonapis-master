<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioRol extends Model
{
    use HasFactory;

    protected $table = 'usuario_rol';
    protected $primaryKey = 'idusuario_rol';
    public $timestamps = false;

    protected $fillable = [
        'rol_idrol',
        'usuario_idusuario'
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_idrol', 'idrol');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_idusuario', 'idusuario');
    }
}