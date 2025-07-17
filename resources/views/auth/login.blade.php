@extends('layouts.app')

@section('title', __('login.title'))

@section('content')
    {{ session('is_referal') }}
    <section class="max-w-md mx-auto my-12 login_page">
        <div class="lang-select" id="langSelect">
            <div class="lang-select-button" id="langSelectButton">
                <span><img id="selectedFlag" src="/images/flags/ru.png" alt=""> <span id="selectedLabel"></span></span>
                <span>▼</span>
            </div>
            <div class="lang-select-dropdown" id="langDropdown">
                <a href="{{ route('lang.switch', 'ru') }}" data-flag="/images/flags/ru.png" data-label="Русский">
                    <img src="/images/flags/ru.png" alt="">
                </a>
                <a href="{{ route('lang.switch', 'en') }}" data-flag="/images/flags/gb.png" data-label="English">
                    <img src="/images/flags/gb.png" alt="">
                </a>
                <a href="{{ route('lang.switch', 'uz') }}" data-flag="/images/flags/uz.png" data-label="Uzbek">
                    <img src="/images/flags/uz.png" alt="">
                </a>
            </div>
        </div>
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
    <script>
        const btn = document.getElementById('langSelectButton');
        const dropdown = document.getElementById('langDropdown');
        const selectedFlag = document.getElementById('selectedFlag');
        const selectedLabel = document.getElementById('selectedLabel');
        const wrapper = document.getElementById('langSelect');

        btn.addEventListener('click', () => {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        dropdown.querySelectorAll('a').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                selectedFlag.src = this.getAttribute('data-flag');
                selectedLabel.textContent = this.getAttribute('data-label');
                dropdown.style.display = 'none';
                window.location.href = this.href;
            });
        });

        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
@endsection
