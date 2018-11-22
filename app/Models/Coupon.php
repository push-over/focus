<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['user_id','topic_id'];

    public $timestamps = false;

    /**关联话题 */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**关联用户 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
