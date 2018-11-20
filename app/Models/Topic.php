<?php

namespace App\Models;
use Carbon\Carbon;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reward', 'adopt', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    protected $casts = [
        'adopt' => 'boolean',
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
}
