<?php

namespace App\Http\ViewComposers;

use App\Models\User;
use Illuminate\View\View;
use Carbon\Carbon;
use DB;

class UserWeekComposer
{
    protected $category;

    public function __construct(User $user)
    {
        $this->user =  User::query()->with('replies')
        ->whereHas('replies', function ($query) {
            $query->where('created_at','>=',Carbon::now()->startOfWeek())
            ->where('created_at','<=',Carbon::now()->endOfWeek());
        })
        ->orderBy(DB::raw('RAND()'))->paginate(12);
    }

    public function compose(View $view)
    {
        $view->with('users', $this->user);
    }
}
