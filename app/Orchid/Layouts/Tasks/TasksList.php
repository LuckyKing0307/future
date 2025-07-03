<?php

namespace App\Orchid\Layouts\Tasks;

use App\Models\BotRoles;
use App\Models\BotUser;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TasksList extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tasks';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Название')->render(function (Tasks $task){
                return "<a href='task/$task->id' style='text-decoration: underline;'>$task->name</a>";
            }),
            TD::make('description', 'Описание'),
            TD::make('importance', 'Куда')->render(function (Tasks $task){
                if ($task->importance==0){
                    return 'TikTok';
                }if ($task->importance==1){
                    return 'FaceBook';
                }if ($task->importance==2){
                    return 'YouTube';
                }
            }),
            TD::make('deadline', 'Дедлайн')->render(function (Tasks $task){
                return $task->deadline ? Carbon::make($task->deadline)->format('H:i:s') : 'Ежедневная Задача';
            }),
            TD::make('took_at', 'Взят в')->render(function (Tasks $task){
                return $task->took_at ? Carbon::make($task->took_at)->format('H:i:s') : 'Пока не взяли';
            }),
            TD::make('group', 'Кто Делает')->render(function (Tasks $task){
                    return User::find($task->user_id)?->name ;
            }),
            TD::make('status', 'Статус')->render(function (Tasks $tasks) {
                return Tasks::STATUS[$tasks->status];
            }),
            TD::make('Изменить')->render(function (Tasks $tasks){
                return ModalToggle::make('Обновить задачу')
                    ->modal('editModal')
                    ->method('update')
                    ->asyncParameters([
                        'task' => $tasks->id
                    ]);
            }),
            TD::make('Удалить')
                ->alignCenter()
                ->render(function (Tasks $task) {
                    return Button::make('Клик')
                        ->confirm('После удаления его уже не вернуть!!!')
                        ->method('delete', ['task' => $task->id]);
                }),
        ];
    }
}
