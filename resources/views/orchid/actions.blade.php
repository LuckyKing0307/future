@php
    /** @var \App\Models\Payment $p */
@endphp

@unless($p->status !== 'pending')
    {{-- Approve --}}
    <x-orchid-action
        :method="'approve'"
        icon="check"
        class="text-success"
        :id="$p->id"
        confirm="Подтвердить платёж №{{ $p->id }}?"
    />

    {{-- Decline --}}
    <x-orchid-action
        :method="'decline'"
        icon="x"
        class="text-danger ms-2"
        :id="$p->id"
        confirm="Отклонить платёж №{{ $p->id }}?"
    />
@endunless
