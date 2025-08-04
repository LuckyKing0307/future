<?php

namespace App\Orchid\Layouts\BotUsers;

use App\Models\BotRoles;
use App\Models\Tariffs;
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
            Input::make('user.ball')
                ->title('Бальная система')
                ->placeholder('10'),
            Input::make('user.payment')
                ->title('Платеж')
                ->placeholder('100'),
            Input::make('user.text')
                ->title('Текст')
                ->placeholder('Бонус от админа'),
            Relation::make('tariff')
                ->fromModel(Tariffs::class, 'name', 'id')
                ->title('Change tariff')
        ];
    }
}
