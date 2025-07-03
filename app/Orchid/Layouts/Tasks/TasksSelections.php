<?php

namespace App\Orchid\Layouts\Tasks;

use App\Orchid\Filters\Tasks\TasksFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class TasksSelections extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            TasksFilter::class
        ];
    }
}
