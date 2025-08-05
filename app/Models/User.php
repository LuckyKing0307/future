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
        'surname',
        'phone',
        'email',
        'password',
        'tariff_id',
        'is_referal',
        'recivers',
        'tariff_at',
        'ball'
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
        'permissions' => 'array',
        'email_verified_at' => 'datetime',
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
        'id' => Where::class,
        'name' => Like::class,
        'email' => Like::class,
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
        'surname',
        'email',
        'updated_at',
        'created_at',
        'block'
    ];

    public function pointsFunction()
    {
        $withdrawal = Withdrawal::where(['user_id' => $this->id])->where(['status' => 'approved'])->sum('amount');
        $payments = Payments::where(['user_id' => $this->id])->where(['status' => 'approved'])->where(['type' => 'payment'])->sum('amount');
        $points = Points::where(['user_id' => $this->id])->sum('points');
        return $points + $payments - $withdrawal;
    }

    public function daysLeft()
    {
        $daysLeft = Carbon::parse($this->tariff_at)
            ->addYear()
            ->diffInDays(now(), false);
        $per = (round($daysLeft) * -1) / 365 * 100;
        return [
            'days' => round($daysLeft) * -1,
            'precentage' => $per,
        ];
    }

    public function earned()
    {

        $points = Points::where(['user_id' => $this->id])->sum('points');
        return $points;
    }

    public function referalPaymnts()
    {
        $points = Payments::where(['user_id' => $this->id])->where(['sub_type' => 'referal'])->sum('amount');
        return $points;
    }

    public function earnedToday()
    {
        $pointsToday = Points::where('user_id', $this->id)
            ->whereBetween('created_at', [now()->startOfDay(), now()])
            ->sum('points');
        return $pointsToday;
    }

    public function tasks()
    {
        return $this->hasMany(UserTask::class);
    }

    public function refferals()
    {
        $refferals = User::where(['is_referal' => $this->id])->get();
        return $refferals;
    }

    public function payments()
    {
        $total = DB::table('payments')
            ->join('tariffs', 'payments.tariff', '=', 'tariffs.id')
            ->where('payments.user_id', $this->id)
            ->where('payments.status','approved')// убери строку, если нужна сумма по всем
            ->sum('tariffs.price');
        return $total;
    }

    public function tariff()
    {
        return Tariffs::find($this->tariff_id);
    }

    public function todayTasks()
    {
        $todayStart = Carbon::today();        // 00:00:00
        $todayEnd = Carbon::today()->endOfDay();
        return UserTask::where('user_id', $this->id)
            ->whereBetween('took_at', [$todayStart, $todayEnd])
            ->count();
    }
}
