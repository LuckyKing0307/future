<?php

namespace App\Orchid\Screens;

use App\Models\Payments;
use App\Models\Payments as Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PaymentsListScreen extends Screen
{
    public $name = 'Платежи';
    public $description = 'Одобрение или отклонение крипто-платежей';

    // сохранённый экземпляр для update/delete
    public ?Payment $payment = null;

    /** Отображаем список */
    public function query(): iterable
    {
        return [
            'payments' => Payment::latest()
                ->paginate(20),
        ];
    }

    /** Кнопки в «шапке» (необязательно) */
    public function commandBar(): iterable
    {
        return [];
    }

    /** Таблица с двумя действиями */
    public function layout(): iterable
    {
        return [
            Layout::table('payments', [
                TD::make('id',     'ID')->sort(),
                TD::make('user.name', 'Пользователь')->render(function (Payment $p){
                    $user = User::find($p->user_id);
                    return $user->phone;
                }),
                TD::make('type',   'Тип'),
                TD::make('tariff', 'Тариф'),
                TD::make('status', 'Статус')->render(fn (Payment $p) => view('orchid.badge', [
                    'color' => $p->status === 'approved' ? 'success' : ($p->status === 'declined' ? 'danger' : 'warning'),
                    'value' => ucfirst($p->status),
                ])),
                TD::make('created_at', 'Создан')->sort(),

                TD::make('actions', 'Действия')->align(TD::ALIGN_CENTER)->render(function (Payment $task) {
                    return Button::make('approve')
                        ->method('approve', ['payment' => $task->id]).' '.Button::make('decline')
                            ->method('decline', ['payment' => $task->id]);
                })
            ]),
        ];
    }

    public function approve(Payment $payment)
    {
        $payment->update(['status' => 'approved']);
        $user = User::find($payment->user_id);
        if ($payment->tariff){
            $user->tariff_id = $payment->tariff;
            $user->save();
        }
        if ($user->is_referal){
            Payments::create([
                'user_id'=>$user->is_referal,
                'status'=>'approved',
                'type'=>'payment',
                'amount'=>intval($payment->amount)/10,
            ]);
        }
        Toast::success("Платёж #{$payment->id} одобрен");
    }

    public function decline(Payment $payment)
    {
        $payment->update(['status' => 'declined']);
        Toast::warning("Платёж #{$payment->id} отклонён");
    }
}
