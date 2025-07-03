<?php

namespace App\Console\Commands;


use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Start Command to get you started';

    public function __construct()
    {
    }

    public function handle()
    {
        info('a');
        $message = $this->getUpdate()->getMessage();
        $userName = $message->from->first_name;

        $response = $this->replyWithMessage([
            'text' => "Привет {$userName}, напиши свой логин и пароль в виде - LOGIN PASSWORD",
        ]);
        $messageId = $response->getMessageId();
    }
}
