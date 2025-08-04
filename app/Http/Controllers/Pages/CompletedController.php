<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\BotUser;
use App\Models\History;
use App\Models\Points;
use App\Models\Tasks;
use App\Models\User;
use App\Models\UserTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompletedController extends Controller
{
    public function index()
    {
        $type = [
            0 => 'tiktok',
            1 => 'facebook',
            2 => 'youtube',
        ];
        $user = Auth::user();
        $completed = UserTask::query()
            ->where('user_id', $user->id)->where('status', 'end')
            ->get();

        $inproccess = UserTask::query()
            ->where('user_id', $user->id)->whereNot('status', 'end')
            ->get();
        return view('pages.completed', compact('completed', 'inproccess', 'type','user'));
    }

    public function me()
    {
        $user = Auth::user();
        $items = [
            ['label' => __('profile.withdrawal'), 'badge' => null, 'href' => route('withdrawal')],
            ['label' => __('profile.add_money'), 'badge' => null, 'href' => route('add_amount')],
            ['label' => __('profile.history'), 'badge' => null, 'href' => route('history')],
            ['label' => __('profile.team_size'), 'badge' => $user->refferals()->count(), 'href' => route('team')],
            ['label' => __('profile.support'), 'badge' => null, 'href' => 'https://t.me/FutureM_Paul'],
            ['label' => __('profile.logout'), 'badge' => null, 'href' => route('data.logout')],
        ];
        return view('pages.me', ['items' => $items, 'user' => $user]);
    }

    public function end(Request $request)
    {
        $user = Auth::id();
        $path = $request->file('photo')
            ->store('task-photos', 'public');
        $data = $request->all();
        $task = UserTask::find($data['id']);
        $task->did_at = Carbon::now();
        $task->status = 'check';
        $task->photo = json_encode(['path' => $path]);;
        $task->save();

        $history = History::where([
            ['user_id' ,'=', $user],
            ['type' ,'=', 'task'],
            ['referance_id' ,'=', $task->id],
        ]);
        if ($history->exists()){
            $history->first()->status = 'check';
        }
        return redirect()->route('completed');
    }

    public function cancel(Request $request)
    {
        $data = $request->all();
        $task = UserTask::find($data['id']);
        $task->user_id = null;
        $task->save();
        return redirect()->route('completed');
    }
}
