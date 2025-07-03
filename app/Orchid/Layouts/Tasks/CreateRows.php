<?php

namespace App\Orchid\Layouts\Tasks;

use App\Models\BotRoles;
use App\Models\BotUser;
use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
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
            Input::make('status')->value('new')->hidden(),
            Input::make('name')
                ->title('Оглавление Задачи')
                ->placeholder('Убрать')
                ->required(),
            Input::make('points')
                ->title('Цена за задачу в USD')
                ->placeholder('10')
                ->type('number')
                ->required(),
            TextArea::make('description')
                ->title('Описание Задачи')
                ->placeholder('Подписаться')
                ->required(),
            Select::make('importance')
                ->options([
                    '0' => 'TicTok',
                    '1' => 'FaceBook',
                    '2' => 'YouTube',
                ])
                ->title('Важность задачи'),
            Relation::make('person')
                ->fromModel(User::class, 'phone', 'id')
                ->title('Выберите участника')
                ->help('Можно выбрать сотрудников если не выбрана категория'),
            DateTimer::make('deadline')
                ->title('Дедлайн')->enableTime(),
        ];
    }
}
