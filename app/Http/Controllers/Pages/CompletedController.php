<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\BotUser;
use App\Models\Points;
use App\Models\Tasks;
use App\Models\User;
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
        $user = Auth::id();
        $completed = Tasks::query()
            ->where('user_id', $user)->where('status', 'end')
            ->get();

        $inproccess = Tasks::query()
            ->where('user_id', $user)->whereNot('status', 'end')
            ->get();
        return view('pages.completed', compact('completed', 'inproccess', 'type'));
    }

    public function me()
    {
        $user = Auth::user();
        $items = [
            ['label' => 'Withdrawal', 'badge' => null, 'href'=> route('withdrawal')],
            ['label' => 'Invite friends', 'badge' => null, 'href'=> route('invite')],
            ['label' => 'Team size', 'badge' => 0, 'href'=> route('team')],
            ['label' => 'Log out', 'badge' => null, 'href'=> route('data.logout')],
        ];
        return view('pages.me', ['items' => $items, 'user' => $user]);
    }

    public function end(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048', // до 2 МБ
        ]);
        info($request->file('photo'));
        $path = $request->file('photo')
            ->store('task-photos', 'public');
        $data = $request->all();
        $task = Tasks::find($data['id']);
        $task->did_at = Carbon::now();
        $task->photo = $path;
        $botUserId = Auth::id();
        Points::create([
            'user_id' => $botUserId,
            'task_id' => $task->id,
            'points' => $task->points,
        ]);
        $task->status = 'check';
        $task->save();
        return redirect()->route('completed');
    }
}
