<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

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
        return view('user.home', compact('user'));
    }

    public function message(User $user)
    {
        $this->authorize('update',$user);
        return view('user.message', compact('user'));
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
                $fileUrl = '/upload/avatar/' . $date . '/' . $path;
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
