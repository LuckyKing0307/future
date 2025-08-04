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

        <div id="tree-simple" class="member-list"></div>
    </div>

    {{-- Copy script --}}
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

    <script src="https://fperucic.github.io/treant-js/vendor/raphael.js"></script>
    <script src="https://fperucic.github.io/treant-js/Treant.js"></script>
    <link rel="stylesheet" href="https://fperucic.github.io/treant-js/Treant.css">
    <script>
        const chart_config = {
            chart: {
                container: "#tree-simple",
                node: {
                    HTMLclass: 'node'
                },
                connectors: {
                    type: 'step',
                    style: {
                        "stroke": "#ccc",
                        "stroke-width": 2
                    }
                }
            },
            nodeStructure: @json($users)
        };

        new Treant(chart_config);
    </script>

    <style>
        .node {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 8px 12px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: 0.2s;
            font-weight: bold;
        }

        .node:hover {
            background: #e0f7ff;
            border-color: #38bdf8;
        }
    </style>
@endsection
