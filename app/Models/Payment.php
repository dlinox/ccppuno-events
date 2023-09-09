<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'event_id', 'series', 'amount', 'payment_date', 'observations', 'voucher_image_path', 'status'
    ];

    protected $casts = [
        'series' => 'string',
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'observations' => 'string',
        'voucher_image_path' => 'string',
        'status' => 'string', // o 'enum' si defines un custom cast para manejar ENUMs
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }


    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
