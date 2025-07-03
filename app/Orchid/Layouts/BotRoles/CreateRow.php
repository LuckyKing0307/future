<?php

namespace App\Orchid\Layouts\BotRoles;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class CreateRow extends Rows
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
            Input::make('role_name')
                ->title('Название Роли')
                ->placeholder('Админ')
                ->required(),
            TextArea::make('role_description')
                ->title('Описание Роли')
                ->placeholder('Управляет людьми')
                ->required(),
        ];
    }
}
