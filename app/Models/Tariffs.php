<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Tariffs extends Model
{
    use HasFactory,AsSource;
    protected $fillable = [
        'name',
        'description',
        'price',
        'usage',
        'payment',
    ];



    protected $allowedFilters = [
        'id',
        'name',
        'price',
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'price',
        'created_at',
    ];
}
