<?php

namespace App\Http\Controllers;

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
            ['id'=>'USDT-TRC20','label'=>'USDT TRC-20','icon'=>asset('images/usdt.png'),'wallet'=>'wallet'],
            ['id'=>'BTC','label'=>'Bitcoin','icon'=>asset('images/bitcoin.png'),'wallet'=>'wallet'],
            ['id'=>'ETH','label'=>'Ethereum','icon'=>asset('images/eth.png'),'wallet'=>'wallet'],
        ];
        $tariff = Tariffs::where('id', $id)->first();
        return view('pages.tariff', ['tariff' => $tariff, 'assets' => $assets]);
    }
    public function buy($asset,$id,$fixed=null){
        $user = Auth::id();
        if ($fixed){
            Payments::create([
                'user_id'=>$user,
                'status'=>'new',
                'type'=>$asset,
                'amount'=>$id,
            ]);
        }else{
            $tariff = Tariffs::find($id);
            Payments::create([
                'user_id'=>$user,
                'status'=>'new',
                'type'=>$asset,
                'tariff'=>$id,
                'amount'=>$tariff->price,
            ]);
        }
        return redirect()->route('tariffs');
    }
}
