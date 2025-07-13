@extends('layouts.app')

@section('title', __('login.title'))

@section('content')
    {{ session('is_referal') }}
    <section class="max-w-md mx-auto my-12 login_page">
        <div class="welcome_header1">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
        </div>
        <div class="welcome_form">
            <h1 class="text-2xl font-bold mb-6 text-center login_text">{{ __('login.header') }}</h1>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <label>
                    {{ __('login.phone') }}
                    <input type="text" name="phone" placeholder="{{ __('login.phone_placeholder') }}" required class="input">
                </label>
                <label>
                    {{ __('login.password') }}
                    <input type="password" name="password" placeholder="{{ __('login.password_placeholder') }}" required class="input">
                </label>

                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <label class="flex items-center text-sm">
                    <span class="ml-2">{{ __('login.remember') }}</span>
                    <input id="remember" type="checkbox" name="remember" class="ml-2" style="width: 15px; height: 15px;">
                </label>

                <button type="submit" class="btn-primary w-full main_btn">{{ __('login.submit') }}</button>
                <a href="{{ route('register') }}" class="main_href">{{ __('login.register_link') }}</a>
            </form>
        </div>
    </section>
@endsection
