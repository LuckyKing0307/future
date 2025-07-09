<div class="layout d-flex justify-content-between">
    <div class="text-black px-2 mt-2 w-25">
        Фотографии Задачи
        @foreach($photos as $photo)
            <img src="{{$photo}}" alt="" style="display: block; min-width: 100px; max-width: 300px;">
        @endforeach
    </div>
</div>
