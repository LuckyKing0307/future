<?php

namespace App\Orchid\Screens;

use App\Models\Tariffs;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TariffsScreen extends Screen
{
    // ───── Название и описание ─────────────────────────────────────────────

    public function name(): string         { return 'Тарифы'; }
    public function description(): string  { return 'Управление тарифными планами'; }

    // ───── Данные ──────────────────────────────────────────────────────────

    public function query(): iterable
    {
        return [
            'tariffs' => Tariffs::
                paginate(10),
        ];
    }

    // ───── Кнопка «Создать тариф» ──────────────────────────────────────────

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать тариф')
                ->modal('createTariffModal')
                ->method('create')
                ->icon('bs.plus-circle'),
        ];
    }

    // ───── Разметка ────────────────────────────────────────────────────────

    public function layout(): iterable
    {
        return [

            // ── таблица со строками тарифов ────────────────────────────────
            Layout::table('tariffs', [

                TD::make('id', 'ID')->sort(),

                // имя + кнопка «Редактировать»
                TD::make('name', 'Название')
                    ->render(fn (Tariffs $tariff) => ModalToggle::make($tariff->name)
                        ->modal('editTariffModal')
                        ->method('update')
                        ->modalTitle('Редактировать тариф')
                        ->asyncParameters(['tariff' => $tariff->id])
                        ->icon('bs.pencil')),

                TD::make('price', 'Цена'),

                TD::make('updated_at', 'Обновлён')
                    ->render(fn (Tariffs $t) => $t->updated_at->toDateTimeString())
                    ->sort(),

                // столбец действий (удаление)
                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->render(function (Tariffs $tariff) {
                        return Button::make('')
                            ->icon('bs.trash')
                            ->method('remove', ['tariff' => $tariff->id])
                            ->confirm('Удалить тариф «'.$tariff->name.'»?');
                    }),
            ]),

            // ── Модалка СОЗДАНИЯ ──────────────────────────────────────────
            Layout::modal('createTariffModal', [
                $this->tariffRows('tariff')
            ])
                ->title('Новый тариф')
                ->applyButton('Создать'),

            // ── Модалка РЕДАКТИРОВАНИЯ (async) ────────────────────────────
            Layout::modal('editTariffModal', [
                $this->tariffRows('tariff'),
            ])
                ->async('asyncGetTariff')          // заполняем поля из БД
                ->applyButton('Сохранить'),
        ];
    }

    // ───── Поля формы (общие для create/update) ───────────────────────────

    protected function tariffRows(string $prefix)
    {
        return Layout::rows([
            \Orchid\Screen\Fields\Input::make("$prefix.name")
                ->title('Название')
                ->required(),

            \Orchid\Screen\Fields\TextArea::make("$prefix.description")
                ->title('Описание')
                ->rows(3)
                ->required(),

            \Orchid\Screen\Fields\Input::make("$prefix.price")
                ->title('Цена, USD')
                ->type('number')
                ->step('0.01')
                ->required(),

            \Orchid\Screen\Fields\Input::make("$prefix.usage")
                ->title('Лимит использования'),

            \Orchid\Screen\Fields\Input::make("$prefix.payment")
                ->title('Период оплаты'),
        ]);
    }

    // ───── Async-метод для модалки редактирования ─────────────────────────

    public function asyncGetTariff(Tariffs $tariff): iterable
    {
        return ['tariff' => $tariff];
    }

    // ───── Handlers ────────────────────────────────────────────────────────

    public function create(Request $request)
    {
        Tariff::create($request->input('tariff'));
        Toast::info('Тариф создан');
    }

    public function update(Request $request, Tariffs $tariff)
    {
        $tariff->update($request->input('tariff'));
        Toast::info('Изменения сохранены');
    }

    public function remove(Tariffs $tariff)
    {
        $tariff->delete();
        Toast::info('Тариф удалён');
    }
}
