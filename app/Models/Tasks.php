<?php

namespace App\Models;

use App\Orchid\Filters\Tasks\TasksFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tasks extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'name',
        'description',
        'importance',
        'status',
        'points',
        'group',
        'person',
        'deadline',
        'photo',
        'took_at',
        'user_id',
        'did_at',
    ];


    public const STATUS = [
        'new' => 'Новые',
        'end' => 'Сделаные',
        'taken' => 'Взятые',
        'check' => 'На проверку',
        'late' => 'С опозданием',
        'wait' => 'Ожидает фото отчет',
        'exit' => 'Не сделанные',
        'latereq' => 'Запрос на дополнительное время',
    ];

}
