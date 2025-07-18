<div class="footer">
    <a href="{{ route('home') }}" class="footer_item">
        <img src="{{ asset('images/home.svg') }}" alt="" class="footer_img">
        <p class="footer_text">{{ __('footer.home') }}</p>
    </a>
    <a href="{{ route('recieve') }}" class="footer_item">
        <img src="{{ asset('images/recieve.svg') }}" alt="" class="footer_img">
        <p class="footer_text">{{ __('footer.recieve') }}</p>
    </a>
    <a href="{{ route('tariffs') }}" class="footer_item">
        <img src="{{ asset('images/buy.svg') }}" alt="" class="footer_img">
        <p class="footer_text">{{ __('footer.buy') }}</p>
    </a>
    <a href="{{ route('completed') }}" class="footer_item">
        <img src="{{ asset('images/completed.svg') }}" alt="" class="footer_img">
        <p class="footer_text">{{ __('footer.completed') }}</p>
    </a>
    <a href="{{ route('me') }}" class="footer_item">
        <img src="{{ asset('images/home.svg') }}" alt="" class="footer_img">
        <p class="footer_text">{{ __('footer.me') }}</p>
    </a>
</div>
