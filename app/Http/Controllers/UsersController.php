<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function login()
    {
        return view('user.login');
    }

    public function logout()
    {

    }

    public function index()
    {
        return view('user.index');
    }

    public function home()
    {
        return view('user.home');
    }

    public function message()
    {
        return view('user.message');
    }

    public function edit()
    {
        return view('user.edit');
    }
}
