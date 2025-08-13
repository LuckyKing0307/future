<div class="layout d-flex justify-content-between">
    <div class="text-black px-2 mt-2 w-25">
        Информация о пользователе
        <p class="small text-muted mt-2 mb-0 text-balance d-flex justify-content-between">ID: <span>{{$user->id}}</span></p>
        <p class="small text-muted mt-2 mb-0 text-balance d-flex justify-content-between">Логин: <span>{{$user->login}}</span></p>
        <p class="small text-muted mt-2 mb-0 text-balance d-flex justify-content-between">Имя: <span>{{$user->name}}</span></p>
        <p class="small text-muted mt-2 mb-0 text-balance d-flex justify-content-between">Фамилия: <span>{{$user->surname}}</span></p>
        <p class="small text-muted mt-2 mb-0 text-balance d-flex justify-content-between">Телефон: <span>{{$user->phone_number}}</span></p>
        <p class="small text-muted mt-2 mb-0 text-balance d-flex justify-content-between">Роль: <span>{{$user->role}}</span></p>
        @if($user->registration)
            <p class="small text-muted mt-2 mb-0 text-balance d-flex justify-content-between">Зарегистрирован: <span>{{$user->registration_day}}</span></p>
        @else
            <p class="small text-muted mt-2 mb-0 text-balance d-flex justify-content-between">Зарегистрирован: <span>Не Зарегистрирован</span></p>
        @endif
    </div>
    <div class="text-black px-2 mt-2 w-25">
        Очки пользователя
        <p class="small text-muted mt-2 mb-0 text-balance d-flex justify-content-between">{{$points}}</p>
    </div>
</div>
<div class="layout d-flex justify-content-between">
    <div class="text-black px-2 mt-2 w-100">
        Рефералы пользователя
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Логин</th>
                <th scope="col">Заблокирован</th>
            </tr>
            </thead>
            <tbody>

            @foreach($referals as $task)

                <tr>
                    <th scope="row">{{$task->id}}</th>
                    <td>{{$task->name}}</td>
                    <td>{{$task->phone}}</td>
                    @if($task->block)
                        <td>Заблокирован</td>
                    @else
                        <td>Не Заблокирован</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="layout d-flex justify-content-between">
    <div class="text-black px-2 mt-2 w-100">
        Задачи пользователя
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Название</th>
                <th scope="col">Описание</th>
                <th scope="col">Статус</th>
                <th scope="col">Дедлайн</th>
            </tr>
            </thead>
            <tbody>

            @foreach($tasks as $task)

                <tr>
                    <th scope="row">{{$task->id}}</th>
                    <td>{{$task->name}}</td>
                    <td>{{$task->description}}</td>
                    @if($task->status=='end')
                        <td>Закончено</td>
                    @elseif($task->status=='late')
                        <td>Закончено с опозданием</td>
                    @elseif($task->status=='exit')
                        <td>Не закончено вовсе</td>
                    @elseif($task->status=='taken')
                        <td>В процессе</td>
                    @endif
                    <td>{{$task->deadline}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="layout d-flex justify-content-between">
    <div class="text-black px-2 mt-2 w-100">
        Ежедневные Задачи пользователя
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Описание</th>
                <th scope="col">Статус</th>
                <th scope="col">Очки</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dayly_tasks as $task)

                <tr>
                    <td>{{$task->name}}</td>
                    <td>{{$task->description}}</td>
                    @if($task->status=='end')
                        <td>Закончено</td>
                    @elseif($task->status=='late')
                        <td>Закончено с опозданием</td>
                    @elseif($task->status=='exit')
                        <td>Не закончено вовсе</td>
                    @elseif($task->status=='taken')
                        <td>В процессе</td>
                    @endif
                    <td>{{$task->points}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
