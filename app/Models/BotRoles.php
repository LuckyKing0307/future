<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class BotRoles extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'role_name',
        'role_description',
    ];
    protected $guarded = [];

}
