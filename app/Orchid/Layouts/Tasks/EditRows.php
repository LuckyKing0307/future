<?php

namespace App\Orchid\Layouts\Tasks;

use App\Models\BotRoles;
use App\Models\BotUser;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
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
            Input::make('task.id')->hidden(),
            Input::make('task.name')
                ->title('Оглавление Задачи')
                ->placeholder('Убрать')
                ->disabled(),
            Input::make('task.points')
                ->title('Очки за задачу')
                ->placeholder('10')
                ->type('number')
                ->required(),
            DateTimer::make('task.deadline')
                ->title('Дедлайн')->enableTime(),
            ];
    }
}
