<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Points;
use App\Models\Tasks;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecieveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->tariff()-$user->todayTasks()<=0){
            $tiktoks = [];                            // только «нулевые»
            $facebooks = [];
            $youtubes = [];
        }else{
            $tasks = Tasks::query()
                ->where('status', 'new')
                ->where(fn($q) => $q
                    ->where('person', $user->id)      // $user->id
                    ->orWhereNull('person')
                )
                ->get()
                ->groupBy('importance');

            $public = $tasks->get(0, collect());          // importance = 0
            $tiktoks = $public;                            // только «нулевые»
            $facebooks = $public->merge($tasks->get(1, collect()));
            $youtubes = $public->merge($tasks->get(2, collect()));
        }
        return view('pages.recieve', compact('tiktoks', 'facebooks', 'youtubes'));
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
        $user = Auth::id();
        $task = Tasks::find($data['id']);
        $task->user_id = $user;
        $task->status = 'taken';
        $task->took_at = now();
        $task->save();
        return $data['id'];
    }
}
