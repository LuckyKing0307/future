<?php

namespace App\Orchid\Screens;

use App\Models\BotUser;
use App\Models\Points;
use App\Models\Tasks;
use App\Models\User;
use App\Orchid\Layouts\Tasks\EveryDayTask;
use App\Orchid\Layouts\Tasks\MessageRows;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Telegram\Bot\Api;

class UserProfile extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public $user;
    public function query(User $user): iterable
    {
        $this->user = $user;
        return [
            'user' => $user,
            'tasks' => Tasks::where([['user_id','=',$user->id],['type','=',null]])->get(),
            'referals' => User::where([['is_referal','=',$user->id]])->get(),
            'dayly_tasks' => Tasks::where([['user_id','=',$user->id],['type', '=', 'dayly']])->get(),
            'points' => Points::where(['user_id'=>$user->id])->sum('points'),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Информация о пользователе';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Заблокировать всех')->method('block')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::view('botuser'),
            Layout::modal('create',EveryDayTask::class)->title('Задача')->applyButton('Создать'),
        ];
    }

    public function create(Request $request)
    {
        $task = $request->all();
        $task['importance']=0;
        unset($task['_token']);
        unset($task['_state']);
        $task = Tasks::create($task);
            $telegram = new Api();
            $user = $this->user;
            if ($user->telegram_id){
                $task->user_id = $user->id;
                $task->person = $user->id;
                $task->status = 'taken';
                $task->type = 'dayly';
                $task->save();
                $task_text = "Новое ежедневное задание: ".$task->name.
                    "\n\nОписание: ".$task->description.
                    "\n\nВажность: ".$task->importance.
                    "\n\nОчки: ".$task->points;
                $telegram->sendMessage([
                    'chat_id' => $user->telegram_id,
                    'text' => $task_text,
                ]);
            }
    }
    public function block()
    {
        $this->user->block=1;
        $this->user->save();
        User::where('is_referal', $this->user->id)
            ->update(['block' => 1]);
    }
}
