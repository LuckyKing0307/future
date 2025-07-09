@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    {{session('is_referal')}}
    <section class="max-w-md mx-auto my-12 login_page">
        <div class="welcome_header1">
            <div class="logo">
                <img src="{{asset('images/logo.png')}}" alt="">
            </div>
        </div>
        <div class="welcome_form">
            <h1 class="text-2xl font-bold mb-6 text-center login_text">User login</h1>

            <form method="POST" action="{{ route('login') }}" class="space-y-4 ">
                @csrf
                <label>Phone number<input type="text" name="phone" placeholder="Номер телефона" required class="input"></label>
                <label>Password<input type="password" name="password" placeholder="Пароль" required class="input"></label>
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <label class="" style="flex-direction: row; align-content: center !important; flex-wrap: wrap !important;">
                    <span class="ml-2 text-sm">Запомнить&nbsp;меня</span>
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        style="width: 15px !important; height: 15px !important; margin:0 !important; margin-left: 10px !important;"
                    >
                </label>
                <button type="submit" class="btn-primary w-full main_btn">Войти</button>
                <a href="{{route('register')}}" class="main_href">Registration</a>
            </form>
        </div>
    </section>
@endsection
