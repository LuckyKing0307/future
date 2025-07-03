<?php

namespace App\Orchid\Screens;

use App\Models\BotRoles;
use App\Orchid\Layouts\BotRoles\CreateRow;
use App\Orchid\Layouts\BotRoles\Roles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Layout;
class BotRolesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'roles' => BotRoles::orderBy('created_at','desc')->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'BotRolesScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Новая Роль')
                ->modal('createModal')
                ->method('create')
                ->icon('plus')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Roles::class,
            Layout::modal('createModal',CreateRow::class)->title('Создать Новую Роль')->applyButton('Создать'),
        ];
    }

    public function create(Request $role)
    {
        $request = $role->all();
        unset($request['_token']);
        unset($request['_state']);
        BotRoles::create($request);
    }
}
