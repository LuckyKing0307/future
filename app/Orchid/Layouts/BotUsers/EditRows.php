<?php

namespace App\Orchid\Layouts\BotUsers;

use App\Models\BotRoles;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class EditRows extends Rows
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
            Input::make('user.id')->hidden(),
            Input::make('user.login')
                ->disabled(),
            Input::make('user.name')
                ->title('Имя')
                ->placeholder('Игорь')
                ->required(),
            Input::make('user.surname')
                ->title('Фамилия')
                ->placeholder('Игорев')
                ->required(),
            Input::make('user.phone_number')
                ->title('Телефон')
                ->mask('(99)999-9999')
                ->required(),
            Relation::make('user.role')
                ->fromModel(BotRoles::class, 'role_name', 'id')
                ->title('Выберите роль сотрудника')
                ->required(),
        ];
    }
}
