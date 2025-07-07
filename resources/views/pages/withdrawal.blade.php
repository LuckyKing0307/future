@extends('layouts.main')
@section('content')
    <div class="member-card">
        <div class="balance">
            Ваш баланс: {{$user->pointsFunction()}}
        </div>
        <form action="{{route('createWithdrawal')}}" method="POST">
            @csrf
            <label for="" style="color: #0e0d12;">
                Вывод
                <input type="number" name="amount" min="0" max="{{$user->pointsFunction()}}" style="color: #0e0d12;">
            </label>
            <button class="end_btn" style="margin-top: 10px;">Отправить на вывод</button>
        </form>
    </div>
@endsection
