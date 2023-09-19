<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [

        'document',
        'name',
        'lastname',
        'deparment',
        'modality',
        'type',
        'email',
        'phone',
        'whatsapp',
        'collegiate_code',
        'pre_registration_date',
        'state',
    ];

    const MODALITIES = ['PRESENCIAL', 'VIRTUAL'];
    const TYPES = ['PLENO', 'OBSERVADOR', 'ESTUDIANTE', 'AGREMIADO'];



    protected $casts = [
        'state' => 'boolean',
    ];

    protected $dates = ['pre_registration_date'];

    // public function getPreRegistrationDateAttribute($value)
    // {
    //     return Carbon::createFromFormat('d/m/Y H:i:s', $value);
    // }

    public function setPreRegistrationDateAttribute($value)
    {
        $this->attributes['pre_registration_date'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
}
