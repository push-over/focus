<?php

namespace App\Http\ViewComposers;

use App\Models\User;
use Illuminate\View\View;
use Carbon\Carbon;
use DB;
use Cache;

class UserWeekComposer
{
    protected $category;

    public function __construct(User $user)
    {
        $users = Cache::remember('week_user', 1440, function(){
            return User::query()->with('replies')
            ->whereHas('replies', function ($query) {
                $query->where('created_at','>=',Carbon::now()->startOfWeek())
                ->where('created_at','<=',Carbon::now()->endOfWeek());
            })
            ->orderBy(DB::raw('RAND()'))->paginate(12);
        });

        $this->user = $users;
    }

    public function compose(View $view)
    {
        $view->with('users', $this->user);
    }
}
