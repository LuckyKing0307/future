@extends('layouts.main')
@section('content')
    <div class="member-card" style="overflow: visible; height: auto;">
        <div class="balance">
            {{ __('withdraw.balance') }}: {{$user->pointsFunction()}} USDT
            <br>
            {{ __('withdraw.fee_notice') }}
        </div>
        <form action="{{route('createWithdrawal')}}" method="POST">
            @csrf
            <label for="" style="color: #0e0d12;">
                {{ __('withdraw.amount_label') }}  {{$user->tariff() ? $user->tariff()->with_amount : 0}} USDT
                <input type="number" name="amount" min="{{$user->tariff() ? $user->tariff()->with_amount : 0}}" max="{{$user->pointsFunction()}}" style="color: #0e0d12;">
                <br><br>
                {{ __('withdraw.recivers_label') }}
                <input type="text" name="recivers" required value="{{$user->recivers}}" style="color: #0e0d12;">
            </label>
            <button class="end_btn" style="margin-top: 10px;">{{ __('withdraw.submit') }}</button>
        </form>
    </div>
@endsection
