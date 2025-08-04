<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class UserTask extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'status',
        'task_id',
        'photo',
        'took_at',
        'user_id',
        'did_at',
        'type'
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

    public function task(): BelongsTo
    {
        return $this->belongsTo(Tasks::class,'task_id');
    }
}
