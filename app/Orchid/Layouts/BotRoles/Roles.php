<?php

namespace App\Orchid\Layouts\BotRoles;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class Roles extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'roles';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('role_name', 'Название Роли'),
            TD::make('role_description', 'Описание'),
        ];
    }
}
