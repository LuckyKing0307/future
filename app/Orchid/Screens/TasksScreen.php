<?php

namespace App\Orchid\Screens;

use App\Models\BotUser;
use App\Models\Tasks;
use App\Models\UserTask;
use App\Orchid\Filters\Tasks\TasksFilter;
use App\Orchid\Layouts\Tasks\CreateRows;
use App\Orchid\Layouts\Tasks\EditRows;
use App\Orchid\Layouts\Tasks\TasksList;
use App\Orchid\Layouts\Tasks\TasksSelections;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class TasksScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public $status;
    public function query($status=null): iterable
    {
        if (isset($status)){
            return [
                'tasks' => Tasks::whereHas('userTask', function ($query) use ($status) {
                    $query->where('status', $status);
                })->orderBy('created_at', 'desc')->paginate(10),
            ];
        }
        return [
            'tasks' => Tasks::filtersApply([TasksFilter::class])->where(['type' => null])->orderBy('created_at', 'desc')->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создать задачи';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать задачу')
                ->modal('createModal')
                ->method('create')
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
            TasksSelections::class,
            TasksList::class,
            Layout::modal('createModal',CreateRows::class)->title('Новая Задача')->applyButton('Создать'),
            Layout::modal('editModal', EditRows::class)->async('asyncGetGame')
        ];
    }

    public function create(Request $request)
    {
        $task = $request->all();
        unset($task['_token']);
        unset($task['_state']);
        Tasks::create($task);
    }

    public function asyncGetGame(Tasks $task): array
    {
        return [
            'task' => $task
        ];
    }

    public function update(Request $request): void
    {
        $task_data = $request->toArray()['task'];
        $task = Tasks::find($request->input('task.id'));
        $task->update($task_data);
        $task->status = 'taken';
        $task->save();
    }

    public function delete(Tasks $task)
    {
        $task->delete();
    }
}
