@extends('layouts.main')

@section('content')
    <div class="member-card">
        <h3 class="mb-2">{{ __('invite.title') }}</h3>

        <div class="flex items-center gap-2 mb-6">
            <input id="crypto"
                   type="text"
                   readonly
                   value="{{ $invite }}"/>

            <button id="copyBtn"
                    type="button"
                    class="end_btn">
                <i class="ti ti-copy"></i>
                {{ __('invite.copy') }}
            </button>
        </div>

        <small id="copyMsg" style="display: none;">{{ __('invite.copied') }}</small>

        {{-- ==== Список рефералов ==== --}}
        <h3 class="mt-8">{{ __('invite.referrals') }}</h3>

        <ul class="member-list">
            @foreach ($users as $user)
                <li class="member-item">
                    <div class="item-info">
                        <i class="ti ti-user-filled"></i>
                        <span class="masked">****{{ substr($user->phone, -4) }}</span>
                    </div>
                    <span class="price">$ {{ $user->pointsFunction() }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        document.getElementById('copyBtn').addEventListener('click', () => {
            const input = document.getElementById('crypto');
            navigator.clipboard.writeText(input.value).then(() => {
                const msg = document.getElementById('copyMsg');
                msg.style.display = 'block';
                setTimeout(() => msg.classList.add('hidden'), 2000);
            }).catch(() => {
                input.select();
                document.execCommand('copy');
            });
        });
    </script>
@endsection
