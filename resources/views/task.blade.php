<div class="layout d-flex justify-content-between">
    <div class="text-black px-2 mt-2 w-25">
        Фотографии Задачи
        @foreach($photos as $photo)
            <img src="{{'https://api.telegram.org/file/bot'.env('TELEGRAM_BOT_TOKEN').'/'.$photo}}" alt="">
        @endforeach
    </div>
</div>
