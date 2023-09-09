<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'start_date', 'end_date', 'cost', 'status'
    ];

    protected $casts = [
        'name' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'cost' => 'decimal:2',
        'status' => 'boolean',
    ];
}
