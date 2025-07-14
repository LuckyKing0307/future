@extends('layouts.main')
@section('content')
    <div class="end_btn">{{ __('tasks.left_today', ['count' => $took_qty]) }}</div>

    <!-- табы -->
    <div class="tab-bar">
        <button class="tab active" data-target="tab-tiktok">{{ __('tasks.tiktok') }}</button>
        <button class="tab" data-target="tab-facebook">{{ __('tasks.facebook') }}</button>
        <button class="tab" data-target="tab-youtube">{{ __('tasks.youtube') }}</button>
    </div>

    <!-- TikTok -->
    <div class="tab-content active" id="tab-tiktok">
        @if(count($tiktoks)>0)
            <ul class="promo-list">
                @foreach($tiktoks as $task)
                    <li class="promo-item task-id-{{$task->id}}" data-id="{{$task->id}}" data-description="{{$task->description}}">
                        <div class="left">
                            <img src="{{asset('images/tiktok.png')}}" alt="TikTok">
                            <span class="app-name">{{$task->name}}</span>
                        </div>
                        <span class="price">${{$user->tariff()->task_price}}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">{{ __('tasks.empty') }}</p>
        @endif
    </div>

    <!-- заглушки -->
    <div class="tab-content" id="tab-facebook">
        @if(count($facebooks)>0)
            <ul class="promo-list">
                @foreach($facebooks as $task)
                    <li class="promo-item task-id-{{$task->id}}" data-id="{{$task->id}}" data-description="{{$task->description}}">
                        <div class="left">
                            <img src="{{asset('images/facebook.png')}}" alt="Facebook">
                            <span class="app-name">{{$task->name}}</span>
                        </div>
                        <span class="price"></span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">{{ __('tasks.empty') }}</p>
        @endif
    </div>
    <div class="tab-content" id="tab-youtube">
        @if(count($youtubes)>0)
            <ul class="promo-list">
                @foreach($youtubes as $task)
                    <li class="promo-item task-id-{{$task->id}}" data-id="{{$task->id}}" data-description="{{$task->description}}">
                        <div class="left">
                            <img src="{{asset('images/youtube.png')}}" alt="YouTube">
                            <span class="app-name">{{$task->name}}</span>
                        </div>
                        <span class="price">${{$user->tariff()->task_price}}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color:#fff;text-align:center;opacity:.6">{{ __('tasks.empty') }}</p>
        @endif
    </div>

    <!-- модальное окно -->
    <div class="modal" id="promoModal">
        <div class="modal-body">
            <button class="close-btn" aria-label="{{ __('tasks.close') }}">&times;</button>
            <h4>{{ __('tasks.offer_details') }}</h4>
            <p>{{ __('tasks.selected_id') }} <strong id="modal-id">—</strong></p>
            <p>{{ __('tasks.description') }} <strong id="modal-description">—</strong></p>
            <button id="takeTaskBtn" class="main_btn">{{ __('tasks.take_task') }}</button>
        </div>
    </div>
    <script>
        const csrfToken = "{{ csrf_token() }}";
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.toggle('active', t === tab));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.toggle('active', c.id === tab.dataset.target));
            });
        });

        const modal = document.getElementById('promoModal');
        const idField = document.getElementById('modal-id');
        const description = document.getElementById('modal-description');

        document.querySelectorAll('.promo-item').forEach(item => {
            item.addEventListener('click', () => {
                idField.textContent = item.dataset.id;
                description.textContent = item.dataset.description;
                modal.classList.add('show');
            });
        });

        modal.querySelector('.close-btn').addEventListener('click', () => modal.classList.remove('show'));
        modal.addEventListener('click', e => {
            if (e.target === modal) modal.classList.remove('show');
        });

        const takeTaskUrl = "{{ route('take-task') }}";
        document.getElementById('takeTaskBtn').addEventListener('click', () => {
            const id = document.getElementById('modal-id').textContent.trim();
            axios.post(takeTaskUrl, { id:id })
                .then(() => {
                    modal.classList.remove('show');
                    document.querySelector(`.task-id-${id}`).style.display = 'none';
                })
                .catch(err => console.error(err));
        });
    </script>
@endsection
