@extends('layouts.main')
@section('content')
    <!-- табы -->
    <div class="tab-bar">
        <button class="tab active" data-target="tab-withdraw">{{ __('finance.withdraw_tab') }}</button>
        <button class="tab" data-target="tab-send">{{ __('finance.send_tab') }}</button>
        <button class="tab" data-target="tab-task">{{ __('profile.tasks') }}</button>
    </div>

    <div class="tab-content" id="tab-withdraw">
        @if(count($withdrawal) > 0)
            <ul class="promo-list">
                @foreach($withdrawal as $task)
                    <li class="promo-item task-id-{{ $task->id }}">
                        <span class="app-name">{{ $task->status }}</span>
                        <div class="left">
                            <span class="app-name">$ {{ $task->amount }}</span>
                        </div>
                        <span class="price">{{ $task->created_at->format('d F - h:i:s') }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">{{ __('finance.empty') }}</p>
        @endif
    </div>

    <div class="tab-content" id="tab-send">
        @if(count($send) > 0)
            <ul class="promo-list">
                @foreach($send as $task)
                    <li class="promo-item task-id-{{ $task->id }}">
                        <div class="">
                            <span class="app-name">{{ __('finance.status') }}:{{ $task->status }}</span>
                            <span class="app-name">{{ __('finance.type') }}:{{ $task->sub_type }}</span>
                        </div>
                        <div class="left">
                            <span class="app-name">$ {{ $task->amount }}</span>
                        </div>
                        <span class="price">{{ $task->created_at->format('d F - h:i:s') }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">{{ __('finance.empty') }}</p>
        @endif
    </div>

    <div class="tab-content" id="tab-task">
        @if(count($points) > 0)
            <ul class="promo-list">
                @foreach($points as $task)
                    <li class="promo-item task-id-{{ $task->id }}">
                        <div class="">
                            <span class="app-name">{{ $task->task->status }}</span>
                        </div>
                        <div class="left">
                            <span class="app-name">$ {{ $point->points }}</span>
                        </div>
                        <span class="price">{{ $task->took_at->format('d F - h:i:s') }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">{{ __('finance.empty') }}</p>
        @endif
    </div>

    <div class="tab-content" id="tab-send">
        @if(count($send) > 0)
            <ul class="promo-list">
                @foreach($send as $task)
                    <li class="promo-item task-id-{{ $task->id }}">
                        <span class="app-name">{{ $task->status }}</span>
                        <div class="left">
                            <span class="app-name">$ {{ $task->amount }}</span>
                        </div>
                        <span class="price">{{ $task->created_at->format('d F - h:i:s') }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">{{ __('finance.empty') }}</p>
        @endif
    </div>

    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.toggle('active', t === tab));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.toggle('active', c.id === tab.dataset.target));
            });
        });
    </script>
@endsection
