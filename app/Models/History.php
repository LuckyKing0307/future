<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class History extends Model
{
    use HasFactory, AsSource;
     protected $fillable = [
         'user_id',
         'type',
         'status',
         'referance_id'
     ];
}
