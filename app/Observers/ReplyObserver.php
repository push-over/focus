<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;
use Cache;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function created(Reply $reply)
    {
        Cache::forget('week_topic');
        Cache::forget('week_user');
        $topic = $reply->topic;
        $reply->topic->increment('reply_count', 1);
        /**触发通知 */
        $topic->user->notify(new TopicReplied($reply));
    }

    public function deleted(Reply $reply)
    {
        if($reply->topic->reply_count >0) {
            $reply->topic->decrement('reply_count', 1);
        }
    }

    public function updated(Reply $reply)
    {
        if($reply->topic->adopt == 1) {
            return ;
        }
        $reply->topic->increment('adopt', 1);
    }
}
