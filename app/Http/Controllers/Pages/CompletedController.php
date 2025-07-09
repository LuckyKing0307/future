<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\BotUser;
use App\Models\History;
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
        $user = Auth::id();
        $request->validate([
            'photo' => 'required|image|max:2048', // до 2 МБ
        ]);
        $path = $request->file('photo')
            ->store('task-photos', 'public');
        $data = $request->all();
        $task = Tasks::find($data['id']);
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
}
