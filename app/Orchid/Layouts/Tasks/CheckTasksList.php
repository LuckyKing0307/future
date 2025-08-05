<?php

namespace App\Orchid\Layouts\Tasks;

use App\Models\BotRoles;
use App\Models\BotUser;
use App\Models\Tasks;
use App\Models\User;
use App\Models\UserTask;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CheckTasksList extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'check_tasks';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Название')->render(function (UserTask $task){
                return "<a href='task/$task->id' style='text-decoration: underline;'>$task->task->name</a>";
            }),
            TD::make('description', 'Описание'),
            TD::make('importance', 'Куда')->render(function (UserTask $task){
                if ($task->task->importance==0){
                    return 'TikTok';
                }if ($task->task->importance==1){
                    return 'FaceBook';
                }if ($task->task->importance==2){
                    return 'YouTube';
                }
            }),
            TD::make('deadline', 'Дедлайн')->render(function (UserTask $task){
                return $task->task->deadline ? Carbon::make($task->task->deadline)->format('H:i:s') : 'Ежедневная Задача';
            }),
            TD::make('took_at', 'Взят в')->render(function (UserTask $task){
                return $task->took_at ? Carbon::make($task->took_at)->format('H:i:s') : 'Пока не взяли';
            }),
            TD::make('group', 'Кто Делает')->render(function (UserTask $task){
                    return User::find($task->user_id)?->name ;
            }),
            TD::make('status', 'Статус')->render(function (UserTask $tasks) {
                return Tasks::STATUS[$tasks->status];
            }),
            TD::make('Изменить')->render(function (UserTask $tasks){
                return ModalToggle::make('Обновить задачу')
                    ->modal('editModal')
                    ->method('update')
                    ->asyncParameters([
                        'task' => $tasks->id
                    ]);
            }),
            TD::make('Удалить')
                ->alignCenter()
                ->render(function (UserTask $task) {
                    return Button::make('Клик')
                        ->confirm('После удаления его уже не вернуть!!!')
                        ->method('delete', ['task' => $task->id]);
                }),
        ];
    }
}
