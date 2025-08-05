<?php

namespace App\Orchid\Screens;

use App\Models\BotUser;
use App\Models\Points;
use App\Models\Tasks;
use App\Models\User;
use App\Models\UserTask;
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
        $task_data = UserTask::find($task);
        $photos = [];
        $photo = json_decode($task_data->photo,1);
        if (isset($photo['path'])){
            $photos[] = 'https://future-m.org/storage/'.$photo['path'];
        }
        return [
            'task' => UserTask::find($task),
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
        return [
            Button::make('Подтвердить')->method('checked'),
            Button::make('Отменить')->method('cancel'),
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
        $user = User::find($task->user_id);
        Points::create([
            'user_id' => $task->user_id,
            'task_id' => $task->id,
            'points' => $user->tariff()->task_price,
        ]);
    }

    public function cancel()
    {
        $task = $this->task;
        $task->status = 'taken';
        $task->save();
    }
}
