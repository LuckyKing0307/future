<div class="welcome_header">
    <div class="logo2">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

    <div class="burger flex items-center gap-3">
        <a href="{{ route('lang.switch', 'ru') }}">
            <img src="{{ asset('images/flags/ru.png') }}" alt="Русский" title="Русский" class="w-6 h-6">
        </a>
        <a href="{{ route('lang.switch', 'en') }}">
            <img src="{{ asset('images/flags/gb.png') }}" alt="English" title="English" class="w-6 h-6">
        </a>
        <a href="{{ route('lang.switch', 'uz') }}">
            <img src="{{ asset('images/flags/uz.png') }}" alt="Uzbek" title="Uzbek" class="w-6 h-6">
        </a>

        <a href="https://t.me/FutureMediaManager02" target="_blank">
            <img src="{{ asset('images/telegram.svg') }}" alt="Telegram" class="w-6 h-6">
        </a>
    </div>
</div>
