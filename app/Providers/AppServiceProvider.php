<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		\App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Topic::observe(\App\Observers\TopicObserver::class);
		\App\Models\Reply::observe(\App\Observers\ReplyObserver::class);


        \Carbon\Carbon::setLocale('zh');

        \View::composer(['pages.index','topics.*','topics_page','login','user.*','auth.*','update_avatar.*'],\App\Http\ViewComposers\CategoryComposer::class);
        \View::composer(['pages.index','topics_page'],\App\Http\ViewComposers\UserWeekComposer::class);
        \View::composer(['pages.index','topics.*','topics_page'],\App\Http\ViewComposers\TopicReplyComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
