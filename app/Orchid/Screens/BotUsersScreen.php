<?php

namespace App\Orchid\Screens;

use App\Models\BotUser;
use App\Models\Payments;
use App\Models\Tariffs;
use App\Models\User;
use App\Orchid\Layouts\BotRoles\CreateRow;
use App\Orchid\Layouts\BotUsers\CreateRows;
use App\Orchid\Layouts\BotUsers\EditRows;
use App\Orchid\Layouts\BotUsers\UsersList;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class BotUsersScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'users' => User::orderBy('created_at', 'desc')->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Сотридники Kosa Farm';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить Сотрудника')
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
            UsersList::class,
            Layout::modal('createModal',CreateRows::class)->title('Новый сотрудник')->applyButton('Создать'),
            Layout::modal('editModal', EditRows::class)->async('asyncGetGame')
        ];
    }


    public function asyncGetGame(User $user): array
    {
        return [
            'user' => $user
        ];
    }

    public function create(Request $request)
    {
        $user = $request->all();
        unset($user['_token']);
        unset($user['_state']);
        BotUser::create($user);
    }

    public function update(Request $request): void
    {
        dd($request->toArray());
        $user = $request->toArray()['user'];
        if ($request->toArray()['tariff']){
           $user_data = User::find($user['id']);
           $user_data->tariff_id = $request->toArray()['tariff'];
        }
        if($user['payment']){

            Payments::create([
                'user_id'=>$user['id'],
                'status'=>'approved',
                'type'=>'payment',
                'sub_type' =>'admin',
                'text' =>$user['text']!=null ? $user['text'] : '',
                'tariff'=>null,
                'amount'=>$user['payment'],
            ]);
        }
    }

    public function delete(User $user)
    {
        $user->delete();
    }
    public function block(User $user)
    {
        if($user->block){
            $user->block = 0;
            $user->save();
        }else{
            $user->block = 1;
            $user->save();
        }
    }
}
