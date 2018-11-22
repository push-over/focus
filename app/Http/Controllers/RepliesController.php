<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use App\Models\Topic;
use Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function store(ReplyRequest $request,Reply $reply)
	{
        $reply->fill($request->all());
        $reply->user_id = Auth::user()->id;
        $reply->topic_id = $request->topic_id;
        $reply->save();
		return redirect()->to($reply->topic->link());
	}

	public function update(ReplyRequest $request, Reply $reply)
	{
		$this->authorize('update', $reply);
		$reply->update($request->all());

		return redirect()->route('replies.show', $reply->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return redirect()->route('replies.index');
    }
}