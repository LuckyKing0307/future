@extends('layouts.main')
@section('content')
    <div class="member-card">
        <div class="balance">
            Ваш баланс: {{$user->pointsFunction()}} USDT
            <br>
            При выводе комиссия 20%
        </div>
        <form action="{{route('createWithdrawal')}}" method="POST">
            @csrf
            <label for="" style="color: #0e0d12;">
                Сумма вывода(миниммум 50 USDT)
                <input type="number" name="amount" min="20" max="{{$user->tariff()->with_amount}}" style="color: #0e0d12;">
                <br><br>
                Реквизиты
                <input type="text" name="recivers" required value="{{$user->recivers}}" style="color: #0e0d12;">
            </label>
            <button class="end_btn" style="margin-top: 10px;">Отправить на вывод</button>
        </form>
    </div>
@endsection
