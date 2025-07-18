@extends('layouts.main')
@section('content')

    <div class="stats">
        <div class="pricing-grid">
            <div class="card">
                <span class="title">{{ __('stats.earned') }}</span>
                <span class="price">$ {{ $user->earned() }}</span>
            </div>
            <div class="card">
                <span class="title">{{ __('stats.earned_today') }}</span>
                <span class="price">$ {{ $user->earnedToday() }}</span>
            </div>
            <div class="card">
                <span class="title">{{ __('stats.bonus') }}</span>
                <span class="price">$ {{ $user->referalPaymnts() }}</span>
            </div>
            <div class="card">
                <span class="title">{{ __('stats.task_earn') }}</span>
                <span class="price">$ {{ $user->earned() }}</span>
            </div>
        </div>
    </div>
    <div class="social-banner">
        <img src="{{asset('images/banner.png')}}" alt="Future-M Banner" class="banner-img">
    </div>
    <div class="member-card">
        <h3>{{ __('stats.members') }}</h3>

        <ul class="member-list">
            @foreach($users as $user)
                @if($user->earned() != 0)
                    <li class="member-item">
                        <div class="item-info">
                            <i class="ti ti-user-filled"></i>
                            <span class="masked">****{{ substr($user->phone, -4) }}</span>
                        </div>
                        <span class="price">$ {{ $user->earned() }}</span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

@endsection
