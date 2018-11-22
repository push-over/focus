<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\Topic;
use App\Models\Reply;

class UsersController extends Controller
{
    public function login()
    {
        return view('user.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function index(User $user)
    {
        $this->authorize('update',$user);
        $topics = $user->topics()->recent()->paginate(20);

        return view('user.index', compact('user','topics'));
    }

    public function home(User $user)
    {
        $topics = Topic::query()->with(['user','topic'])->where('user_id',$user->id)->where('type','提问')->orderBy('created_at','desc')->paginate(15);
        $replies = Reply::query()->with(['user','topic'])->where('user_id',$user->id)->orderBy('updated_at','desc')->paginate(5);
        return view('user.home', compact('user','replies','topics'));
    }

    public function message(User $user)
    {
        $this->authorize('update',$user);
        $notifications = $user->notifications()->paginate(5);
        $user->markAsRead();
        return view('user.message', compact('user','notifications'));
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update',$user);
        $user->update($request->all());
        return [];
    }

    public function update_avatar(Request $request,User $user)
    {
        $this->authorize('update',$user);
        $status = 0;
        $data = [];
        if ($request->method() == 'POST') {
            $date = date('Ymd');
            $path = $request->file('file')->store('', 'upload');
            if ($path) {
                $fileUrl = '/uploads/avatar/' . $date . '/' . $path;
                $status = 1;
                $data['url'] = $fileUrl;
                $message = '上传成功';

                $user->update([
                    'avatar' => $fileUrl,
                ]);
            } else {
                $message = "上传失败";
            }
        } else {
            $message = "参数错误";
        }
        return showMsg($status, $message, $data);

    }

}
