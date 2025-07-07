<?php

namespace App\Orchid\Screens;

use App\Models\Withdrawal;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;

class WithdrawalScreen extends Screen
{
    /** Заголовок страницы в шапке */
    public $name = 'Заявки на вывод средств';

    /** Краткое описание (необязательно) */
    public $description = 'Просмотр, подтверждение и отклонение выводов';

    /* -----------------------------------------------------------------
     |  Данные для таблицы
     * -----------------------------------------------------------------*/
    public function query(): iterable
    {
        return [
            'withdrawals' => Withdrawal::orderBy('created_at', 'desc')
                ->paginate(),
        ];
    }

    /* -----------------------------------------------------------------
     |  Кнопки действий над всей страницей
     * -----------------------------------------------------------------*/
    public function commandBar(): iterable
    {
        return [];   // здесь можно добавить экспорт или массовые операции
    }

    /* -----------------------------------------------------------------
     |  Таблица с заявками
     * -----------------------------------------------------------------*/
    public function layout(): iterable
    {
        return [
            Layout::table('withdrawals', [
                TD::make('id', 'ID')->sort(),

                TD::make('user_id', 'User ID'),

                TD::make('amount', 'Amount')
                    ->align(TD::ALIGN_RIGHT)
                    ->render(fn (Withdrawal $w) => number_format($w->amount, 2)),

                TD::make('status', 'Status')
                    ->render(fn (Withdrawal $w) =>
                    view('orchid.badge', ['color' => $w->status,'value' => $w->status])
                    ),

                TD::make('created_at', 'Created')
                    ->sort()
                    ->render(fn (Withdrawal $w) => $w->created_at->toDateTimeString()),

                TD::make('updated_at', 'Updated')
                    ->render(fn (Withdrawal $w) => $w->updated_at->toDateTimeString()),

                TD::make('Actions')
                    ->align(TD::ALIGN_CENTER)
                    ->render(function (Withdrawal $w) {
                        return DropDown::make('Action')
                            ->icon('options-vertical')
                            ->list([
                                Button::make('Approve')
                                    ->icon('check')
                                    ->method('approve', ['id' => $w->id])
                                    ->confirm('Подтвердить вывод?')
                                    ->canSee($w->status !== 'approved'),

                                Button::make('Decline')
                                    ->icon('ban')
                                    ->method('decline', ['id' => $w->id])
                                    ->confirm('Отклонить вывод?')
                                    ->canSee($w->status !== 'declined'),
                            ]);
                    }),
            ]),
        ];
    }

    /* -----------------------------------------------------------------
     |  Методы-действия
     * -----------------------------------------------------------------*/
    public function approve(int $id): void
    {
        Withdrawal::findOrFail($id)->update(['status' => 'approved']);
        Toast::info('Заявка подтверждена');
    }

    public function decline(int $id): void
    {
        Withdrawal::findOrFail($id)->update(['status' => 'declined']);
        Toast::warning('Заявка отклонена');
    }
}
