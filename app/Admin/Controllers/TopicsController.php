<?php

namespace App\Admin\Controllers;

use App\Models\Topic;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Category;

class TopicsController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('话题')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('修改')
            ->description('话题')
            ->body($this->form()->edit($id));
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Topic);
        $grid->model()->with(['category','user'])->orderBy('id', 'desc');
        $grid->id('Id');
        $grid->title('标题');
        $grid->column('user.name','用户');
        $grid->column('category.name', '所属分类');
        $grid->reply_count('回复量');
        $grid->view_count('浏览量');
        $grid->order('排序');
        $grid->adopt('是否已采纳')->display(function ($abopt) {
            return $abopt ? '是' : '否';
        });

        $grid->is_top('是否置顶')->display(function ($is_top) {
            return $is_top ? '是' : '否';
        });
        $grid->good_topic('是否加精')->display(function ($good_topic) {
            return $good_topic ? '是' : '否';
        });
        $grid->created_at('发表时间');

        $grid->disableRowSelector();
        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Topic);

        $category_data = Category::all();
        $category_name = [];

        foreach ($category_data as $v) {
            $category_name[$v['id']] = $v->name;
        }


        $form->text('title', '标题');
        $form->text('user_id', '用户ID')->default(1);
        $form->select('category_id', '所属分类')->options($category_name);
        $form->select('type', '类型')->options([
            '5' => '公共',
            '6' => '动态'
        ]);
        $form->editor('body', '内容');
        $form->radio('is_top', '是否置顶')->options([1 => '是', '0' => '否'])->default(0);
        $form->radio('good_topic', '是否加精')->options([1 => '是', '0' => '否'])->default(0);;


        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
        });
        return $form;
    }
}
