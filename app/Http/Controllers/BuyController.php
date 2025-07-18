<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Payments;
use App\Models\Tariffs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyController extends Controller
{
    public function index(){
        $user = Auth::user();
        $tariffs = Tariffs::all();
        return view('pages.buy', ['tariffs' => $tariffs,'user' => $user]);
    }
    public function show($id){
        $assets = [
            ['id'=>'USDT-TRC20','label'=>'USDT TRC-20','icon'=>asset('images/usdt.png'),'wallet'=>'TGPkLEF8xyqR3pBBsSfgy6Z1gF1drqE8R1'],
            ['id'=>'BTC','label'=>'Bitcoin','icon'=>asset('images/bitcoin.png'),'wallet'=>'12zkC8B5nkkWqayTEF1VVWG81K9gx96xTD'],
            ['id'=>'ETH','label'=>'Ethereum','icon'=>asset('images/eth.png'),'wallet'=>'0x1feedf8046da14e7af5323bbb23db43b5c25b28e'],
        ];
        $tariff = Tariffs::where('id', $id)->first();
        return view('pages.tariff', ['tariff' => $tariff, 'assets' => $assets]);
    }
    public function buy($asset,$id,$fixed=null){
        $user = Auth::id();
        $check = Payments::where([['user_id','=',$user],['status','=','new']]);
        if ($fixed){
            $payment = Payments::create([
                'user_id'=>$user,
                'status'=>'new',
                'type'=>$asset,
                'sub_type' =>'payment',
                'amount'=>$id,
            ]);
        }else{
            if(!$check->exists()){
                $tariff = Tariffs::find($id);
                $payment = Payments::create([
                    'user_id'=>$user,
                    'status'=>'new',
                    'type'=>$asset,
                    'sub_type' =>'payment',
                    'tariff'=>$id,
                    'amount'=>$tariff->price,
                ]);
            }
        }
        return redirect()->route('tariffs');
    }
}
