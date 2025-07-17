<div class="welcome_header">
    <div class="logo2">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

    <div class="burger flex items-center gap-3">
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
        <a href="https://t.me/FutureMediaManager02" target="_blank">
            <img src="{{ asset('images/telegram.svg') }}" alt="Telegram" class="w-6 h-6">
        </a>
    </div>
</div>

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
