<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use Auth;
use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;
use App\Models\Reply;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'topic']]);
    }

    public function index()
    {
        return view('topics.index', compact('topics'));
    }

    public function show(Topic $topic,Request $request)
    {
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

		$replies = Reply::query()->with(['user','topic'])->where('topic_id',$topic->id)->orderBy('updated_at','desc')->paginate(5);

        return view('topics.show', compact('topic','replies'));
    }

    public function create(Topic $topic)
    {
        return view('topics.create_and_edit', compact('topic'));
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::user()->id;
        $topic->save();
        return redirect()->to($topic->link());
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

        return redirect()->to($topic->link());
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index');
    }

    public function topic(Request $request)
    {

        $topics = Topic::query()->with(['user', 'category']);
        if ($request->category_id) {
            $topics->where('category_id', $request->category_id);
        }

        $topic = $topics->withOrder('recent')->paginate($request->pageSize);

        return $topic;
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        $data = [
            'success' => false,
            'msg' => '上传失败!',
            'file_path' => '',
        ];

        if ($file = $request->upload_file) {
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);

            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
            }
        }
        return $data;
    }
}
