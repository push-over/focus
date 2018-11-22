<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['adopt', 'content'];

    protected $casts = [
        'adopt' => 'boolean',
    ];

    /**关联用户 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**关联话题 */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
