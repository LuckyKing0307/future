<?php

namespace App\Orchid\Layouts\BotUsers;

use App\Models\BotRoles;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class CreateRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('login')
                ->title('Логин')
                ->placeholder('looool0307')
                ->required(),
            Input::make('password')
                ->title('Пароль')
                ->type('password')
                ->placeholder('Пароль')
                ->required(),
            Input::make('name')
                ->title('Имя')
                ->placeholder('Игорь')
                ->required(),
            Input::make('surname')
                ->title('Фамилия')
                ->placeholder('Игорев')
                ->required(),
            Input::make('phone_number')
                ->title('Телефон')
                ->mask('(99) 999-9999')
                ->required(),
            Relation::make('role')
                ->fromModel(BotRoles::class, 'role_name', 'id')
                ->title('Выберите роль сотрудника')
                ->required(),
        ];
    }
}
