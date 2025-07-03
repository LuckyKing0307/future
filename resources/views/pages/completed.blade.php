@extends('layouts.main')
@section('content')
    <!-- табы -->
    <div class="tab-bar">
        <button class="tab active" data-target="tab-completed">Completed</button>
        <button class="tab" data-target="tab-in-process">In-process</button>
    </div>

    <!-- TikTok -->
    <div class="tab-content active" id="tab-completed">
        @if(count($completed)>0)
            <ul class="promo-list">
                @foreach($completed as $task)
                    <li class="promo-item-text task-id-{{$task->id}}" data-id="{{$task->id}}"
                        data-description="{{$task->description}}">
                        <div class="promo-item-data">
                            <div class="left">
                                <img src="{{asset('images/'.$type[$task->importance].'.png')}}" alt="TikTok">
                                <span class="app-name">{{$task->name}}</span>
                            </div>
                            <span class="price">${{$task->points}}</span>
                        </div>
                        <br>
                        <span class="description">{{$task->description}}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">Тут пока пусто</p>
        @endif
    </div>

    <!-- заглушки -->
    <div class="tab-content" id="tab-in-process">
        @if(count($inproccess)>0)
            <ul class="promo-list">
                @foreach($inproccess as $task)
                    <li class="promo-item-text task-id-{{$task->id}}" data-id="{{$task->id}}"
                        data-description="{{$task->description}}">
                        <div class="promo-item-data">
                            <div class="left">
                                <img src="{{asset('images/'.$type[$task->importance].'.png')}}" alt="TikTok">
                                <span class="app-name">{{$task->name}}</span>
                            </div>
                            <span class="price">${{$task->points}}</span>
                        </div>
                        <span class="description">Статус: {{$task->status}}</span>
                        <br>
                        <br>
                        <span class="description">{{$task->description}}</span>
                        <br>
                        <br>
                        <form action="{{route('end')}}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="photo" value="{{$task->id}}"  class="filepond" required>
                            <input type="text" name="id" value="{{$task->id}}" hidden>
                            <button class="end_btn">Завершить</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">Тут пока пусто</p>
        @endif
    </div>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        FilePond.parse(document.body);
        const csrfToken = "{{ csrf_token() }}";
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
