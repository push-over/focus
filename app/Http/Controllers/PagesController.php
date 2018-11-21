<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Category;

class PagesController extends Controller
{
    public function index(Request $request,Category $category)
    {

        $topics = Topic::query()->where('is_top', true)->orderBy('updated_at', 'desc')->paginate(5);

        return view('pages.index', compact('topics','category'));
    }
}
