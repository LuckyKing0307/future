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
            Input::make('user.payment')
                ->title('Платеж')
                ->placeholder('Игорь')
                ->required(),
        ];
    }
}
