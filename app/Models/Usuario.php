<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'usuario';
    protected $primaryKey = 'idusuario';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'persona_idpersona'
    ];

    protected $hidden = [
        'password'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_idpersona', 'idpersona');
    }

    // Add this relationship to the Usuario model
    public function roles()
    {
        return $this->hasMany(UsuarioRol::class, 'usuario_idusuario', 'idusuario');
    }
}