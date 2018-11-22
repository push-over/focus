<?php

namespace App\Observers;

use App\Jobs\TranslateSlug;
use App\Models\Topic;
use Cache;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function saved(Topic $topic)
    {
        /**翻译 */
        if (!$topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
        Cache::forget('topic');
    }

    public function updated()
    {
        dispatch(new TranslateSlug($topic));
    }

}
