<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Payments extends Model
{
    use HasFactory, AsSource;
    protected $fillable = [
        'user_id',
        'status',
        'type',
        'tariff',
        'amount',
        'sub_type',
        'text'
    ];
}
