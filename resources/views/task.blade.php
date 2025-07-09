<div class="layout d-flex justify-content-between">
    <div class="text-black px-2 mt-2 w-25">
        Фотографии Задачи
        @foreach($photos as $photo)
            <img src="{{$photo}}" alt="">
        @endforeach
    </div>
</div>
