<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Points;
use App\Models\Tasks;
use App\Models\User;
use App\Models\UserTask;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecieveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $took_qty = (($user->tariff()?->usage)-$user->todayTasks());
        $taskIds = UserTask::where('user_id', $user->id)->pluck('task_id')->toArray();
        if($took_qty<=0){
            $tiktoks = [];                            // только «нулевые»
            $facebooks = [];
            $youtubes = [];
        }else{
            $tiktoks = Tasks::query()
                ->where('status', 'new')
                ->where('importance', 0)
                ->whereNotIn('id', $taskIds)
                ->get();

            $facebooks = Tasks::query()
                ->where('status', 'new')
                ->where('importance', 1)
                ->whereNotIn('id', $taskIds)
                ->get();

            $youtubes = Tasks::query()
                ->where('status', 'new')
                ->where('importance', 2)
                ->whereNotIn('id', $taskIds)
                ->get();
        }
        return view('pages.recieve', compact('tiktoks', 'facebooks','took_qty', 'youtubes','user'));
    }

    public function withdrawal(Request $request)
    {
        $user = Auth::id();
        $amount = $request->all()['amount'];

        $with = Withdrawal::create([
            'user_id' => $user,
            'status' => 'new',
            'amount' => $amount
        ]);
    }

    public function takeTask(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $took_qty = (($user->tariff()?->usage)-$user->todayTasks());
        if ($took_qty>0 and $user->block!=1){
            $task = Tasks::find($data['id']);
            UserTask::create([
                'type' => 'task',
                'status' => 'taken',
                'task_id' => $task->id,
                'took_at' => now(),
                'user_id' => $user->id,
            ]);
        }
        return $data['id'];
    }
}
