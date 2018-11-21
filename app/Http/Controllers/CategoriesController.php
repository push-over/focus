<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
        $topics = Topic::query()->where('category_id', $category->id)->where('is_top',true)->orderBy('updated_at','desc')->paginate(5);
        return view('pages.index', compact('topics'));
    }
}
