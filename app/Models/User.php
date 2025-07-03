<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'tariff_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];
    public function username(): string
    {
        return 'phone';
    }
    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
           'id'         => Where::class,
           'name'       => Like::class,
           'email'      => Like::class,
           'updated_at' => WhereDateStartEnd::class,
           'created_at' => WhereDateStartEnd::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];

    public function points()
    {
        $points = Points::where(['user_id'=>$this->id])->sum('points');
        return $points;
    }


    public function tasks()
    {
        $points = Tasks::where(['user_id'=>$this->id]);
        return $points;
    }
    public function payments()
    {
        $total = DB::table('payments')
            ->join('tariffs', 'payments.tariff', '=', 'tariffs.id')
            ->where('payments.user_id', $this->id)      // убери строку, если нужна сумма по всем
            ->sum('tariffs.price');
        return $total;
    }

    public function tariff()
    {
        return $this->tariff_id ? Tariffs::find($this->tariff_id)->usage : 0;
    }


    public function todayTasks(){
        $todayStart = Carbon::today();        // 00:00:00
        $todayEnd   = Carbon::today()->endOfDay();
        return Tasks::where('user_id', $this->id)
            ->whereBetween('took_at', [$todayStart, $todayEnd])
            ->count();
    }
}
