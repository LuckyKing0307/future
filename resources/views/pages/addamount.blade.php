@extends('layouts.main')
@section('content')
    <div class="container mx-auto flex items-center justify-center px-4 py-16">
        <div class="glass-card w-full max-w-lg p-8 text-white">
            <h1 class="text-center text-3xl font-bold mb-8">{{ __('crypto.title') }}</h1>

            {{-- варианты валют --}}
            <div id="cryptoList" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                @foreach($assets as $asset)
                    <div class="crypto-option" data-asset="{{ $asset['id'] }}" data-wallet="{{ $asset['wallet'] }}">
                        <img class="crypto-icon" src="{{ $asset['icon'] }}" alt="{{ $asset['label'] }}">
                        <span class="label">{{ $asset['label'] }}</span>
                        <span class="label" style="display: none;">{{ $asset['wallet'] }}</span>
                    </div>
                @endforeach
            </div>

            <p>{{ __('crypto.to_pay') }}</p>
            <input type="text" name="crypto" id="crypto" disabled>

            <br><br>
            <p>{{ __('crypto.amount') }}</p>
            <input id="amount" type="text" placeholder="{{ __('crypto.enter_amount') }}" style="color: #0e0d12 !important;">

            <button id="payBtn" disabled>{{ __('crypto.pay_button') }}</button>
        </div>
    </div>

    <script>
        const list   = document.getElementById('cryptoList');
        const amount = document.getElementById('amount');
        const payBtn = document.getElementById('payBtn');

        let selectedAsset = null;

        list.addEventListener('click', e => {
            const option = e.target.closest('.crypto-option');
            if (!option) return;

            list.querySelectorAll('.crypto-option').forEach(el => el.classList.remove('active'));
            option.classList.add('active');

            selectedAsset = option.dataset.asset;
            document.getElementById('crypto').value = option.dataset.wallet;
            payBtn.disabled = false;
        });

        payBtn.addEventListener('click', () => {
            if (!selectedAsset || !amount.value) return;
            window.location.href = `/buy/${selectedAsset}/${amount.value}/1`;
        });
    </script>
@endsection
