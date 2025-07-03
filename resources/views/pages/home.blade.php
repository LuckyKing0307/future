@extends('layouts.main')
@section('content')

<div class="stats">
    <div class="pricing-grid">
        <div class="card">
            <span class="title">Earned</span>
            <span class="price">$ {{$user->points()}}</span>
        </div>
        <div class="card">
            <span class="title">Spend</span>
            <span class="price">$ {{$user->payments()}}</span>
        </div>
        <div class="card">
            <span class="title">Member</span>
            <span class="price">$864</span>
        </div>
        <div class="card">
            <span class="title">Member</span>
            <span class="price">$864</span>
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
                    <span class="masked">****{{$user->id}}</span>
                </div>
                <span class="price">$ {{$user->points()}}</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
