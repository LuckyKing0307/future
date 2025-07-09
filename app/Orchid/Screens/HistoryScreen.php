<?php

namespace App\Orchid\Screens;

use App\Models\History;
use App\Models\User;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
class HistoryScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'histories' => History::latest()->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'HistoryScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('histories', [
                TD::make('id', 'ID')->sort(),

                TD::make('type', 'Тип')
                    ->filter(TD::FILTER_TEXT),

                TD::make('user_id', 'Пользователь')->render(function (History $history) {
                    $user = User::find($history->user_id);
                    return $user->phone;
                })
                    ->filter(TD::FILTER_TEXT),

                TD::make('created_at', 'Создано')
                    ->sort()
                    ->render(fn($h) => $h->created_at?->toDateTimeString()),

                TD::make('updated_at', 'Обновлено')
                    ->render(fn($h) => $h->updated_at?->toDateTimeString()),
            ]),
        ];
    }
}
