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

            <form method="POST" action="{{ route('register') }}" class="space-y-4 ">
                @csrf
                <label>Name<input type="text"  name="name" placeholder="Имя" required class="input w-full"></label>
                <label>Surname<input type="text"  name="surname" placeholder="Фамилия" required class="input w-full"></label>
                <label>Phone number<input type="text"  name="phone" placeholder="Номер телефона" required class="input w-full"></label>
                <label>Password<input type="password" name="password" placeholder="Пароль" required class="input w-full"></label>
                <label>Confirm password<input type="password" name="password_confirmation" placeholder="Повторите пароль" required class="input w-full"></label>
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <button class="btn-primary w-full main_btn"  type="submit">Registration</button>
                <a href="{{route('login')}}" class="main_href">Log In</a>
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>
    </section>
@endsection
