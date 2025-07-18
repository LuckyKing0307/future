<?php

namespace App\Models;

use App\Models\Tasks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Points extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'user_id',
        'task_id',
        'points',
    ];

    public function task()
    {
        return $this->belongsTo(Tasks::class, 'task_id', 'id');
    }
}
