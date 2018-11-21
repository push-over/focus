<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'topic']]);
    }

    public function index()
    {
        $topics = Topic::query()->where('is_top', true)->orderBy('updated_at', 'desc')->paginate(5);
        return view('topics.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
        return view('topics.show',compact('topic'));
    }

    public function create(Topic $topic)
    {
        return view('topics.create_and_edit', compact('topic'));
    }

    public function store(TopicRequest $request)
    {
        $topic = Topic::create($request->all());
        return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        return view('topics.create_and_edit', compact('topic'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
    }

    public function topic(Request $request)
    {

        $topics = Topic::query()->with(['user', 'category']);
        if ($request->category_id) {
            $topics->where('category_id', $request->category_id);
        }

        if($request->order)
        {
            $order = explode('=',$request->order);
            $topic = $topics->withOrder($order[1] ? $order[1] : 'recent')->paginate($request->pageSize);

        }
        $topic = $topics->withOrder('recent')->paginate($request->pageSize);

        return $topic;
    }
}