<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class BotUser extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'login',
        'password',
        'name',
        'surname',
        'phone_number',
        'photo',
        'role',
        'telegram_id',
        'registration',
        'registration_day'
    ];
}
