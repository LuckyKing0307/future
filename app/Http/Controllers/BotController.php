<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Api;

class BotController extends Controller
{
    protected $telegram;
    public $menu = [
        'Меню' => 'menu',
        'Задачи' => 'tasks',
        'Мои задачи' => 'tasks',
        'Профиль' => 'profile',
//        'Настройки' => 'settings',
        'Статистика' => 'history',
    ];
    /**
     * Create a new controller instance.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Show the bot information.
     */
    public function show()
    {
        $response = $this->telegram->getMe();
        return $response;
    }

    /**
     * Show the bot information.
     */
    public function getUpdates()
    {
        $response = $this->telegram->commandsHandler();
        foreach ($response as $update) {
            $text = "";
            $user = BotUser::where(['telegram_id' => $update->getMessage()->chat->id]);
            if (!$user->exists()){
                $data = explode(' ',$update->getMessage()->text);
                if (count($data)<=1){
                    $text = "Не правильно ввели логин и пароль";
                }else{
                    $botUser = BotUser::where(['login' => $data[0],'password' => $data[1]]);
                    if ($botUser->exists()){
                        $account = $botUser->get()->first();
                        $account->telegram_id = $update->getMessage()->from->id;
                        $account->registration = true;
                        $account->registration_day = Carbon::now();
                        $account->save();
                        $text = "Добро пожаловать {$account->name}";
                    }else{
                        $text = "Такого профиля с таким паролем нет попробуйте еще";
                    }
                }
                $response = $this->telegram->sendMessage([
                    'chat_id' => $update->getMessage()->from->id,
                    'text' => $text
                ]);

            }
            else{
                if ($update->isType('callback_query')){
                    $callback = new CollBackController($update->callback_query, $this->telegram);
                    $callback->closeCallback();
                    $callback->store();
                }else{
                    $user = $user->get()->first();
                    $menu = new MenuController($this->telegram, $user);
                    $message = $update->getMessage()->text;
                    if (isset($this->menu[$message])){
                        $function = $this->menu[$message];
                        $menu->$function($this->telegram, $user);
                    }else{
                        if (isset($update->getMessage()->photo)){
                            $tasks = Tasks::where(['status' => 'wait', 'user_id' => $user->id]);
                            if ($tasks->exists()){
                                $task = $tasks->get()->first();
                                $task->photo = json_encode($update->getMessage()->photo);
                                $task->status = 'check';
                                $task->save();
                            }
                        }else{
                            $menu->menu();
                        }
                    }
                }
            }
            return $response;
        }

    }
}
