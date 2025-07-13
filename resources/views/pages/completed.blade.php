@extends('layouts.main')
@section('content')
    <!-- табы -->
    <div class="tab-bar">
        <button class="tab active" data-target="tab-completed">{{ __('tasks.completed_tab') }}</button>
        <button class="tab" data-target="tab-in-process">{{ __('tasks.in_process_tab') }}</button>
    </div>

    <!-- Completed -->
    <div class="tab-content active" id="tab-completed">
        @if(count($completed) > 0)
            <ul class="promo-list">
                @foreach($completed as $task)
                    <li class="promo-item-text task-id-{{ $task->id }}" data-id="{{ $task->id }}" data-description="{{ $task->description }}">
                        <div class="promo-item-data">
                            <div class="left">
                                <img src="{{ asset('images/'.$type[$task->importance].'.png') }}" alt="{{ $type[$task->importance] }}">
                                <span class="app-name">
                                    <a href="{{ $task->name }}" class="sq-btn {{ $type[$task->importance] }}">
                                        {{ strtoupper($type[$task->importance]) }}
                                    </a>
                                </span>
                            </div>
                            <span class="price">${{ $task->points }}</span>
                        </div>
                        <br>
                        <span class="description">{{ $task->description }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">{{ __('tasks.empty') }}</p>
        @endif
    </div>

    <!-- In-process -->
    <div class="tab-content" id="tab-in-process">
        @if(count($inproccess) > 0)
            <ul class="promo-list">
                @foreach($inproccess as $task)
                    <li class="promo-item-text task-id-{{ $task->id }}" data-id="{{ $task->id }}" data-description="{{ $task->description }}">
                        <div class="promo-item-data">
                            <div class="left">
                                <img src="{{ asset('images/'.$type[$task->importance].'.png') }}" alt="{{ $type[$task->importance] }}">
                                <span class="app-name">
                                    <a href="{{ $task->name }}" class="sq-btn {{ $type[$task->importance] }}">
                                        {{ strtoupper($type[$task->importance]) }}
                                    </a>
                                </span>
                            </div>
                            <span class="price">${{ $task->points }}</span>
                        </div>
                        <span class="description">{{ __('tasks.status') }}: {{ $task->status }}</span>
                        <br><br>
                        <span class="description">{{ $task->description }}</span>
                        <br><br>
                        <form action="{{ route('end') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="photo" class="filepond" required>
                            <input type="text" name="id" value="{{ $task->id }}" hidden>
                            <button class="end_btn">{{ __('tasks.finish') }}</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">{{ __('tasks.empty') }}</p>
        @endif
    </div>

    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        FilePond.setOptions({
            instantUpload: false,
            storeAsFile: true
        });
        FilePond.parse(document.body);

        const csrfToken = "{{ csrf_token() }}";

        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.toggle('active', t === tab));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.toggle('active', c.id === tab.dataset.target));
            });
        });
    </script>
@endsection
