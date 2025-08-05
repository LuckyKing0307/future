<?php

namespace App\Console\Commands;

use App\Models\Tasks;
use App\Models\UserTask;
use Illuminate\Console\Command;
use Illuminate\Console\View\Components\Task;

class ParceTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parce-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Tasks::all();
        foreach ($tasks as $task) {
            if($task->user_id){
                UserTask::create([
                    'type' => $task->type ?? 'none',
                    'status' => $task->status,
                    'task_id' => $task->id,
                    'photo' => $task->photo,
                    'took_at' => $task->took_at,
                    'user_id' => $task->user_id,
                ]);
            }
        }
    }
}
