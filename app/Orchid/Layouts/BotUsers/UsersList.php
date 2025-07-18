<?php

namespace App\Orchid\Layouts\BotUsers;

use App\Models\BotRoles;
use App\Models\BotUser;
use App\Models\Payments as Payment;
use App\Models\Tariffs;
use App\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class UsersList extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'users';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),
            TD::make('name', 'NAME'),
            TD::make('surname', 'SURNAME'),
            TD::make('login', 'Логин')->render(function (User $user){
                return "<a href='botuser/$user->id' style='text-decoration: underline;'>$user->phone</a>";
            }),
            TD::make('referals', 'Рефералы')->render(function (User $user){
                return $user->refferals()->count();
            }),
            TD::make('amount', 'Баланс')->render(function (User $user){
                return $user->pointsFunction();
            }),
            TD::make('block', 'Заблокирован')->render(function (User $user){
                return $user->block ? 'Заблокирован' : 'Активен';
            }),
            TD::make('tariff', 'Тариф')->render(function (User $user){
                return $user->tariff() ? $user->tariff()->name : 'Нету';
            }),
            TD::make('Add Founds')->render(function (User $game){
                return ModalToggle::make('Edit')
                    ->modal('editModal')
                    ->method('update')
                    ->modalTitle('Edit Game')
                    ->asyncParameters([
                        'user' => $game->id
                    ]);
            }),
            TD::make('Удалить')
                ->alignCenter()
                ->render(function (User $user) {
                    return Button::make('Клик')
                        ->confirm('После удаления его уже не вернуть!!!')
                        ->method('delete', ['user' => $user->id]);
                }),
            TD::make('Заблокировать')
                ->alignCenter()
                ->render(function (User $user) {
                    if($user->block){
                        return Button::make('Разблокировать')
                            ->method('block', ['user' => $user->id]);
                    }else{
                        return Button::make('Заблокировать')
                            ->method('block', ['user' => $user->id]);
                    }
                }),
        ];
    }
}
