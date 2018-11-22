<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;

class User extends Authenticatable
{
    /**重写 */
    use Notifiable {
        notify as protected laravelNotify;
    }

    /**通知消息 */
    public function notify($instance)
    {
        if($this->id == Auth::user()->id) {
            return;
        }

        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    /**清除消息 */
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'sex', 'description', 'city', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'provider', 'provider_id',
    ];

    /**关联话题 */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**关联回复 */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
