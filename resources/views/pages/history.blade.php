@extends('layouts.main')
@section('content')
    <!-- табы -->
    <div class="tab-bar">
        <button class="tab active" data-target="tab-withdraw">Withdraw</button>
        <button class="tab" data-target="tab-send">Send</button>
    </div>

    <div class="tab-content" id="tab-withdraw">
        @if(count($withdrawal)>0)
            <ul class="promo-list">
                @foreach($withdrawal as $task)
                    <li class="promo-item task-id-{{$task->id}}">
                        <span class="app-name">{{$task->status}}</span>
                        <div class="left">
                            <span class="app-name">$ {{$task->amount}}</span>
                        </div>
                        <span class="price">{{$task->created_at->format('d F - h:i:s')}}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">Тут пока пусто</p>
        @endif
    </div>
    <div class="tab-content" id="tab-send">
        @if(count($send)>0)
            <ul class="promo-list">
                @foreach($send as $task)
                    <li class="promo-item task-id-{{$task->id}}">
                        <span class="app-name">{{$task->status}}</span>
                        <div class="left">
                            <span class="app-name">$ {{$task->amount}}</span>
                        </div>
                        <span class="price">{{$task->created_at->format('d F - h:i:s')}}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">Тут пока пусто</p>
        @endif
    </div>
    <script>
        /* --- табы --- */
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                /* активный таб */
                document.querySelectorAll('.tab').forEach(t => t.classList.toggle('active', t === tab));
                /* соответствующий контент */
                document.querySelectorAll('.tab-content').forEach(c => c.classList.toggle('active', c.id === tab.dataset.target));
            });
        });
    </script>
@endsection
