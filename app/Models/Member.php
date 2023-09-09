<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'document', 'name', 'paternal_surname', 'maternal_surname', 'email', 'phone', 'collegiate_code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'document' => 'string',
        'name' => 'string',
        'paternal_surname' => 'string',
        'maternal_surname' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'collegiate_code' => 'string',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
