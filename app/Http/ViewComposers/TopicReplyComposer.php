<?php

namespace App\Http\ViewComposers;

use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\View\View;
use DB;

class TopicReplyComposer
{
    protected $category;

    public function __construct(Topic $topic)
    {
        $this->topic = Topic::query()->where('updated_at', '>=', Carbon::now()->startOfWeek())
            ->where('updated_at', '<=', Carbon::now()->endOfWeek())
            ->orderBy(DB::raw('RAND()'))
            ->paginate(12);
    }

    public function compose(View $view)
    {
        $view->with('topic_reply', $this->topic);
    }
}
