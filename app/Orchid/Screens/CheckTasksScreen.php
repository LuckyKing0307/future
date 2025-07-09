<?php

namespace App\Orchid\Screens;

use App\Models\BotUser;
use App\Models\Points;
use App\Models\Tasks;
use App\Models\User;
use App\Orchid\Layouts\Tasks\MessageRows;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Telegram\Bot\Api;

class CheckTasksScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public $task;
    public $photos;
    public function query($task): iterable
    {
        $telegram = new Api();
        $task_data = Tasks::find($task);
        $photos = [];
        $photo = json_decode($task_data->photo,1);
        if (isset($photo['path'])){
            $photos[] = 'https://future-m.org/storage/'.$photo['path'];
        }
        return [
            'task' => Tasks::find($task),
            'photos' => $photos,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Информация О Задаче';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        if ($this->task->status=='check'){
            return [
                Button::make('Подтвердить')->method('checked'),
                ModalToggle::make('Комментарий')
                    ->modal('sendMessage')
                    ->method('sendMessage')
                    ->icon('plus')
            ];
        }
        return [
            ModalToggle::make('Комментарий')
            ->modal('sendMessage')
            ->method('sendMessage')
            ->icon('plus')
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
            Layout::view('task'),
            Layout::modal('sendMessage',MessageRows::class)->title('Комментарий')->applyButton('Отправить'),
        ];
    }

    public function checked()
    {
        $task = $this->task;
        $task->status = 'end';
        $task->took_at = Carbon::now();
        $task->save();
        $telegram = new Api();
        Points::create([
            'user_id' => $task->person,
            'task_id' => $task->id,
            'points' => $task->points,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $task = $this->task;
        $task->status = 'taken';
        $task->deadline = $request->all()['task']['deadline'];
        $task->points = $request->all()['task']['points'];
        $task->save();
        $telegram = new Api();
        $user = BotUser::find($task->person);
        if ($user->telegram_id){
            $telegram->sendMessage([
                'chat_id' => $user->telegram_id,
                'text' => "Задача обновлена с комментарием: ".$request->all()['message'],
            ]);
        }
    }
}
