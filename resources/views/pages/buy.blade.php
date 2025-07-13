@extends('layouts.main')
@section('content')
    <div class="tariffs_body">
        @foreach($tariffs as $tariff)
            <div class="tariff">
                <h3 class="tariff_name">{{ __('tariff.name') }}: {{ $tariff->name }}</h3>
                <h5 class="tariff_description">{{ __('tariff.description') }}: {{ $tariff->description }}</h5>
                <div class="tariff_price">{{ __('tariff.price') }}: {{ $tariff->price }}</div>
                <div class="tariff_tasks">{{ __('tariff.tasks_per_day') }}: {{ $tariff->usage }}</div>
                @if($user->tariff_id < $tariff->id)
                    <div class="tariff_link end_btn">
                        <a href="{{ route('tariff', [$tariff->id]) }}" class="link">{{ __('tariff.buy') }}</a>
                    </div>
                @else
                    <div class="tariff_link end_btn">{{ __('tariff.buy') }}</div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
