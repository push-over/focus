<?php

namespace App\Models;
use Carbon\Carbon;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reward', 'adopt', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug','is_top','good_topic'];

    protected $casts = [
        'adopt' => 'boolean',
        'is_top' => 'boolean',
        'good_topic' => 'boolean',
    ];

    protected $appends = ['created_at_human'];

    /**关联分类 */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**关联用户 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtHumanAttribute()
    {
        return Carbon::createFromTimeString($this->attributes['updated_at'])->diffForHumans();
    }

    /**排序 */
    public function scopeWithOrder($query,$order)
    {
        switch ($order){
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }

        return $query->with('user','category');
    }

    /**热议 */
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('reply_count','desc');
    }

    /**最新 */
    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
}
