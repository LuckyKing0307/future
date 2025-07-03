@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <section class="max-w-md mx-auto my-12 login_page">
        <div class="welcome_header">
            <div class="logo">
                <img src="{{asset('images/logo.svg')}}" alt="">
            </div>
        </div>
        <div class="welcome_form">
            <h1 class="text-2xl font-bold mb-6 text-center login_text">User login</h1>

            <form method="POST" action="{{ route('login') }}" class="space-y-4 ">
                @csrf
                <label>Phone number<input type="text" name="phone" placeholder="+998991234567" required class="input"></label>
                <label>Password<input type="password" name="password" placeholder="Пароль" required class="input"></label>
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <button type="submit" class="btn-primary w-full main_btn">Войти</button>
                <a href="{{route('register')}}" class="main_href">Registration</a>
            </form>
        </div>
    </section>
@endsection
