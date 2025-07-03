@extends('layouts.main')
@section('content')
    <div class="tariffs_body">
        @foreach($tariffs as $tariff)
            <div class="tariff">
                <h3 class="tariff_name">Name: {{$tariff->name}}</h3>
                <h5 class="tariff_description">Description: {{$tariff->description}}</h5>
                <div class="tariff_price">Price: {{$tariff->price}}</div>
                <div class="tariff_tasks">Tasks Per Day: {{$tariff->usage}}</div>
                @if($user->tariff_id<$tariff->id)
                    <div class="tariff_link end_btn"><a href="{{route('tariff',[$tariff->id])}}" class="link">Buy</a></div>
                @else
                    <div class="tariff_link end_btn">Buy</div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
