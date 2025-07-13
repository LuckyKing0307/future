@extends('layouts.app')

@section('title', __('register.title'))

@section('content')
    {{ session('is_referal') }}
    <section class="max-w-md mx-auto my-12 login_page">
        <div class="welcome_header1">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
        </div>
        <div class="welcome_form">
            <h1 class="text-2xl font-bold mb-6 text-center login_text">{{ __('register.header') }}</h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <label>
                    {{ __('register.name') }}
                    <input type="text" name="name" placeholder="{{ __('register.name_placeholder') }}" required class="input w-full">
                </label>
                <label>
                    {{ __('register.surname') }}
                    <input type="text" name="surname" placeholder="{{ __('register.surname_placeholder') }}" required class="input w-full">
                </label>
                <label>
                    {{ __('register.referral') }}
                    <input type="text" name="referral" placeholder="{{ __('register.referral_placeholder') }}" class="input w-full">
                </label>
                <label>
                    {{ __('register.phone') }}
                    <input type="text" name="phone" placeholder="{{ __('register.phone_placeholder') }}" required class="input w-full">
                </label>
                <label>
                    {{ __('register.password') }}
                    <input type="password" name="password" placeholder="{{ __('register.password_placeholder') }}" required class="input w-full">
                </label>
                <label>
                    {{ __('register.password_confirmation') }}
                    <input type="password" name="password_confirmation" placeholder="{{ __('register.password_confirmation_placeholder') }}" required class="input w-full">
                </label>

                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <button class="btn-primary w-full main_btn" type="submit">{{ __('register.submit') }}</button>
                <a href="{{ route('login') }}" class="main_href">{{ __('register.login_link') }}</a>
            </form>
        </div>
    </section>
@endsection
