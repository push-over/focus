<?php

namespace App\Http\ViewComposers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category->all();
    }

    public function compose(View $view)
    {
        $view->with('category', $this->category);
    }
}
