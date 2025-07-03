<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\Points;
use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class MenuController extends Controller
{
    public Api $telegram;
    public BotUser $botUser;
    public function __construct(Api $telegram, BotUser $botUser)
    {
        $this->telegram = $telegram;
        $this->botUser = $botUser;
    }

    public function menu()
    {
        $reply_markup = Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(false)
            ->row([
                Keyboard::button('Задачи'),
                Keyboard::button('Мои задачи'),
            ])
            ->row([
                Keyboard::button('Профиль'),
                Keyboard::button('Статистика'),
            ]);

        $response = $this->telegram->sendMessage([
            'chat_id' => $this->botUser->telegram_id,
            'text' => 'Здравствуйте '.$this->botUser->name,
            'reply_markup' => $reply_markup
        ]);
    }

    public function tasks()
    {
        $tasks = Tasks::where([['person', '=', $this->botUser->id],['status', '=', 'new']])->orWhere([['group', '=', $this->botUser->role],['status', '=', 'new']])->get();
        foreach ($tasks as $task){
            $keysBoards = [];

            $yes = [
                'v' => $task->id,
                'f' => 'take',
            ];
            $no = [
                'v' => $task->id,
                'f' => 'cancel',
            ];
            $reply_markup = Keyboard::make()->inline()
                ->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true)
                ->row([
                    Keyboard::button(['text' => 'Взать', 'callback_data' => json_encode($yes)]),
                    Keyboard::button(['text' => 'Отказаться', 'callback_data' => json_encode($no)]),
                ]);
            $reply_markup = $this->addRows($reply_markup, $keysBoards);
            $task_text = "Задание: ".$task->name.
                "\n\nОписание: ".$task->description.
                "\n\nВажность: ".$task->importance.
                "\nДедлайн: ".Carbon::make($task->deadline)->format('d-m-Y H:i:s');

            $this->telegram->sendMessage([
                'chat_id' => $this->botUser->telegram_id,
                'text' => $task_text,
                'reply_markup' => $reply_markup,
            ]);
        }
        if (count($tasks)==0){
            $this->telegram->sendMessage([
                'chat_id' => $this->botUser->telegram_id,
                'text' => 'Для вас больше нет заданий',
            ]);
        }
    }

    public function profile()
    {
        $poinst = Points::where(['user_id' => $this->botUser->id])->sum('points');
        $tasks = Tasks::where(['user_id' => $this->botUser->id])->count();
        $active = Tasks::where(['user_id' => $this->botUser->id])->where(['status' => 'taken'])->count();
        $end = Tasks::where(['user_id' => $this->botUser->id])->where(['status' => 'end'])->count();
        $late = Tasks::where(['user_id' => $this->botUser->id])->where(['status' => 'late'])->count();
        $exit = Tasks::where(['user_id' => $this->botUser->id])->where(['status' => 'exit'])->count();
        $text = "Логин: ".$this->botUser->login.
            "\nИмя: ".$this->botUser->name.
            "\nФамилия: ".$this->botUser->surname.
            "\nТелефон: ".$this->botUser->phone_number.
            "\n\nНакоплено Очков: ".$poinst.
            "\n\nОбщее количество задач: ".$tasks.
            "\n   Активных Задач - ".$active.
            "\n   Успешно законченых Задач - ".$end.
            "\n   С опозданием законченых Задач - ".$late.
            "\n   Отмененных Задач - ".$exit;
        $response = $this->telegram->sendMessage([
            'chat_id' => $this->botUser->telegram_id,
            'text' => $text,
        ]);

    }

    public function settings()
    {
        $response = $this->telegram->sendMessage([
            'chat_id' => $this->botUser->telegram_id,
            'text' => 'Настройки',
        ]);

    }

    public function history()
    {
        $tasks = Tasks::where(['user_id' => $this->botUser->id])->get();
        foreach ($tasks as $task){
            $data = [];
            $task_text = "Задание: ".$task->name.
                "\n\nОписание: ".$task->description.
                "\n\nВажность: ".$task->importance.
                "\nДедлайн: ".Carbon::make($task->deadline)->format('d-m-Y H:i:s');
            if ($task->status=='taken'){
                $end = [
                    'v'=>$task->id,
                    'f'=>'end',
                ];
                $exit = [
                    'v'=>$task->id,
                    'f'=>'exit',
                ];
                $late = [
                    'v'=>$task->id,
                    'f'=>'latereq',
                ];
                $reply_markup = Keyboard::make()->inline()
                    ->setResizeKeyboard(true)
                    ->setOneTimeKeyboard(true)
                    ->row([
                        Keyboard::button(['text' => 'Отправить на проверку', 'callback_data' => json_encode($end)]),
                        Keyboard::button(['text' => 'Отказаться', 'callback_data' => json_encode($exit)]),
                    ])
                    ->row([
                        Keyboard::button(['text' => 'Запросить еще время', 'callback_data' => json_encode($late)]),
                    ]);
                $data['reply_markup'] = $reply_markup;
            }
            if ($task->status=='end'){
                $task_text .= "\n\nСтатус: Закончено";
            }
            if ($task->status=='late'){
                $task_text .= "\n\nСтатус: Закончено с опозданием";
            }
            if ($task->status=='exit'){
                $task_text .= "\n\nСтатус: Не сделано";
            }
            if ($task->status=='latereq'){
                $task_text .= "\n\nСтатус: В ожиднии ответа администратора";
            }
            $data['chat_id'] = $this->botUser->telegram_id;
            $data['text'] = $task_text;
            $this->telegram->sendMessage($data);
        }
        if (count($tasks)==0){
            $this->telegram->sendMessage([
                'chat_id' => $this->botUser->telegram_id,
                'text' => 'У вас пустая история',
            ]);
        }
    }


    protected function addRows($rows,$keysBoards)
    {
        $reply_markup = $rows->row($keysBoards);
        return $reply_markup;
    }
}
