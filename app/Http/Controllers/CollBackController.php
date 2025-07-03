<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\Points;
use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class CollBackController extends Controller
{

    protected $request;
    protected Api $telegram;

    public function __construct($request, Api $telegram)
    {
        $this->request = $request;
        $this->telegram = $telegram;
    }

    public function closeCallback()
    {
        $params = [
            'callback_query_id' => $this->request->id,
            'text' => 'success',
        ];
        $this->telegram->answerCallbackQuery($params);
    }

    public function store()
    {
        $data = json_decode($this->request->data, 1);
        $function = $data['f'];
        self::$function($data);
        $params = [
            'message_id' => $this->request->message->message_id,
            'chat_id' => $this->request->message->chat->id
        ];
        $this->telegram->deleteMessage($params);
        return true;
    }

    public function register($data)
    {
        $hours = [
            1 => '1 час',
            2 => '2 часа',
            3 => '3 часа',
            5 => '5 часов',
            8 => '8 часов',
            10 => '10 часов',
            11 => 'Другое время',
        ];
        $task = Tasks::find($data['o']);

        $yes = [
            'v' => $data['o'],
            'o' => $data['v'],
            'f' => 'take',
        ];
        $no = [
            'v' => $data['o'],
            'o' => $data['v'],
            'f' => 'cancel',
        ];
        $reply_markup = Keyboard::make()->inline()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->row([
                Keyboard::button(['text' => 'Взать', 'callback_data' => json_encode($yes)]),
                Keyboard::button(['text' => 'Отказаться', 'callback_data' => json_encode($no)]),
            ]);

        $task_text = "Задание: " . $task->name .
            "\n\nОписание: " . $task->description .
            "\n\nЗаймет времени: " . $hours[$data['v']];

        $this->telegram->sendMessage([
            'chat_id' => $this->request->message->chat->id,
            'text' => $task_text,
            'reply_markup' => $reply_markup,
        ]);
    }

    public function take($data)
    {
        $user = BotUser::where(['telegram_id' => $this->request->message->chat->id])->get()->first();
        $task = Tasks::find($data['v']);
        $task->user_id = $user->id;
        $task->status = 'taken';
        $task->save();

        $task_text = "Вы взяли Задание: " . $task->name .
            "\n\nОписание: " . $task->description .
            "\n\nДедлайн до: " . $task->deadline;

        $this->telegram->sendMessage([
            'chat_id' => $this->request->message->chat->id,
            'text' => $task_text,
        ]);

    }

    public function exit($data)
    {
        $task = Tasks::find($data['v']);
        $task->status = 'exit';
        $task->did_at = Carbon::now();
        $task->save();
        $botUser = BotUser::where(['telegram_id' => $this->request->message->chat->id]);

        if ($botUser->exists()) {
            $botUser = $botUser->get()->first();
            Points::create([
                'user_id' => $botUser->id,
                'task_id' => $task->id,
                'points' => 0,
            ]);
        }

        $this->telegram->sendMessage([
            'chat_id' => $this->request->message->chat->id,
            'text' => 'Вы закрыли задачу не закончив. ' . $task->name,
        ]);
    }

    public function end($data)
    {
        $task = Tasks::find($data['v']);
        $task->did_at = Carbon::now();
        $text = 'Отправьте фото для задачи. ' . $task->name;
        $botUser = BotUser::where(['telegram_id' => $this->request->message->chat->id]);
        if ($task->deadline > $task->did_at) {
            if ($botUser->exists()) {
                $botUser = $botUser->get()->first();
                Points::create([
                    'user_id' => $botUser->id,
                    'task_id' => $task->id,
                    'points' => 2,
                ]);
            }
            $task->status = 'wait';
        } else {
            if ($botUser->exists()) {
                $botUser = $botUser->get()->first();
                Points::create([
                    'user_id' => $botUser->id,
                    'task_id' => $task->id,
                    'points' => 1,
                ]);
            }
            $text = 'Вы с задержкой закрыли задачу. ' . $task->name;
            $task->status = 'late';
        }
        $task->save();

        $this->telegram->sendMessage([
            'chat_id' => $this->request->message->chat->id,
            'text' => $text,
        ]);
    }

    public function latereq($data)
    {
        $task = Tasks::find($data['v']);
        $task->status = 'check';
        $task->save();
        $text = 'Запрос на дополнительное время отправлено. Задача: ' . $task->name;
        $this->telegram->sendMessage([
            'chat_id' => $this->request->message->chat->id,
            'text' => $text,
        ]);
    }

    public function cancel($data)
    {

    }
}
