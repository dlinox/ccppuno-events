<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Member extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    const MODALITIES = ['PRESENCIAL', 'VIRTUAL'];
    const TYPES = ['PLENO', 'OBSERVADOR', 'ESTUDIANTE', 'AGREMIADO'];

    protected $fillable = [

        'document',
        'name',
        'paternal_surname',
        'maternal_surname',
        'deparment',
        'degree',
        'modality',
        'type',
        'email',
        'phone',
        'whatsapp',
        'collegiate_code',
        'state',
        'password',
        'email_verified_at',
        'pre_registration_date',
    ];



    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'state' => 'boolean',
        'password' => 'hashed',
    ];

    protected $dates = ['pre_registration_date'];

    // public function getPreRegistrationDateAttribute($value)
    // {
    //     return Carbon::createFromFormat('d/m/Y H:i:s', $value);
    // }

    public $headers =  [
        ['text' => "DNI", 'value' => "document", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "name", 'short' => false, 'order' => 'ASC'],
        ['text' => "Modalidad", 'value' => "modality", 'short' => false, 'order' => 'ASC'],
        ['text' => "Participante", 'value' => "type", 'short' => false, 'order' => 'ASC'],
        ['text' => "Correo", 'value' => "email", 'short' => false, 'order' => 'ASC'],
        ['text' => "Celular", 'value' => "phone", 'short' => false, 'order' => 'ASC'],
        // ['text' => "Cod. Agremiado", 'value' => "collegiate_code", 'short' => false, 'order' => 'ASC'],
        // ['text' => "Correo Verificado", 'value' => "email_verified_at", 'short' => false, 'order' => 'ASC'],
    ];

    public function setPreRegistrationDateAttribute($value)
    {
        $this->attributes['pre_registration_date'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
