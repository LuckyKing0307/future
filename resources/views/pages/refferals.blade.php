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
        <h3 class="mt-8">{{ __('invite.referrals') }}</h3>
        <div id="tree-simple" class="member-list Treant"></div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Данные дерева из контроллера
        const nodeStructure = @json($users, JSON_UNESCAPED_UNICODE);

        new Treant({
            chart: {
                container: "#tree-simple",
                rootOrientation: "NORTH",   // сверху вниз
                levelSeparation: 70,
                siblingSeparation: 30,
                subTeeSeparation: 45,
                animateOnInit: true
            },
            node: {
                HTMLclass: "ref-node"
            },
            connector: {
                type: "step",
                style: { "stroke-width": 2 }
            },
            nodeStructure
        });
    });

    // Копирование реф-ссылки
    (function () {
        const btn = document.getElementById('copyBtn');
        const inp = document.getElementById('crypto');
        const msg = document.getElementById('copyMsg');
        if (!btn || !inp) return;
        btn.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(inp.value);
                if (msg) {
                    msg.style.display = 'inline';
                    setTimeout(() => msg.style.display = 'none', 1500);
                }
            } catch (e) {
                inp.select(); document.execCommand('copy');
                if (msg) {
                    msg.style.display = 'inline';
                    setTimeout(() => msg.style.display = 'none', 1500);
                }
            }
        });
    })();
</script>
