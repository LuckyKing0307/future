<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Payments;
use App\Models\Tariffs;
use App\Models\WaitRequest;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function withdrawal(){
        $user = Auth::user();
        return view('pages.withdrawal', compact('user'));
    }
    public function createWithdrawal(Request $request){
        $data = $request->all();
        $user = Auth::user();
        if($user->recivers!=$data['recivers']){
            $user->recivers = $data['recivers'];
            $user->save();
        }
        $task = Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $data['amount'],
            'recivers' => $data['recivers'],
            'status' => 'new',
        ]);
        $history = History::create([
            'user_id' => $user->id,
            'type' => 'withdrawal',
            'status' => 'new',
            'referance_id' => $task->id,
        ]);
        if ($history->exists()){
            $history->first()->status = 'check';
        }
        return redirect()->route('me');
    }


    public function history(){
        $send = Payments::where('user_id', Auth::id())->orderBy('created_at','desc')->get();
        $withdrawal = Withdrawal::where('user_id', Auth::id())->orderBy('created_at','desc')->get();

        return view('pages.history', compact('send', 'withdrawal'));
    }


    public function addAmount(){
        $assets = [
            ['id'=>'USDT-TRC20','label'=>'USDT TRC-20','icon'=>asset('images/usdt.png'),'wallet'=>'TGPkLEF8xyqR3pBBsSfgy6Z1gF1drqE8R1'],
            ['id'=>'BTC','label'=>'Bitcoin','icon'=>asset('images/bitcoin.png'),'wallet'=>'12zkC8B5nkkWqayTEF1VVWG81K9gx96xTD'],
            ['id'=>'ETH','label'=>'Ethereum','icon'=>asset('images/eth.png'),'wallet'=>'0x1feedf8046da14e7af5323bbb23db43b5c25b28e'],
        ];
        return view('pages.addamount', ['assets' => $assets]);
    }
    public function team(){
        $invite = url('/?ref=' . Auth::id());
        $user = Auth::user();
        $users = $user->refferals();
        return view('pages/refferals', compact('users', 'invite'));
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
