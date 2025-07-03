<?php

namespace App\Console\Commands;

use App\Http\Controllers\BotController;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Api;
class StartBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Telegram Bot';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while (true){
            $telegram = new Api();
            $response = new BotController($telegram);
            $telegram->addCommand(\App\Telegram\Commands\StartCommand::class);
            $array = $response->getUpdates();
            var_dump($array);
            if (is_string($array) or is_int($array) or ($array and count($array)>0)){
                var_dump($array);
            }

        }
    }
}
