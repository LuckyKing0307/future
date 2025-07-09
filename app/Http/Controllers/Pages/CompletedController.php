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
            ['label' => 'Add Money', 'badge' => null, 'href'=> route('add_amount')],
            ['label' => 'History', 'badge' => null, 'href'=> route('history')],
            ['label' => 'Team size', 'badge' => $user->refferals()->count(), 'href'=> route('team')],
            ['label' => 'Support', 'badge' => null, 'href'=> route('history')],
            ['label' => 'Log out', 'badge' => null, 'href'=> route('data.logout')],
        ];
        return view('pages.me', ['items' => $items, 'user' => $user]);
    }

    public function end(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048', // до 2 МБ
        ]);
        $path = $request->file('photo')
            ->store('task-photos', 'public');
        $data = $request->all();
        $task = Tasks::find($data['id']);
        $task->did_at = Carbon::now();
        $task->status = 'check';
        $task->photo = $path;
        $task->save();
        $botUserId = Auth::id();
        Points::create([
            'user_id' => $botUserId,
            'task_id' => $task->id,
            'points' => $task->points,
        ]);
        return redirect()->route('completed');
    }
}
