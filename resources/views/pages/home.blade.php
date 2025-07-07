@extends('layouts.main')
@section('content')

<div class="stats">
    <div class="pricing-grid">
        <div class="card">
            <span class="title">Earned</span>
            <span class="price">$ {{$user->pointsFunction()}}</span>
        </div>
        <div class="card">
            <span class="title">Spend</span>
            <span class="price">$ {{$user->payments()}}</span>
        </div>
    </div>
</div>
<div class="member-card">
    <h3>Member</h3>

    <ul class="member-list">
        @foreach($users as $user)
            <li class="member-item">
                <div class="item-info">
                    <i class="ti ti-user-filled"></i>
                    <span class="masked">****{{substr($user->phone, -4)}}</span>
                </div>
                <span class="price">$ {{$user->pointsFunction()}}</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
