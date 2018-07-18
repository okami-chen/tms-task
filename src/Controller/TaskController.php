<?php

namespace OkamiChen\TmsTask\Controller;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use OkamiChen\TmsTask\Entity\Task;
use Encore\Admin\Form\NestedForm;
use Encore\Admin\Grid\Displayers\Actions;

class TaskController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('任务系统');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('任务系统');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('任务系统');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Task::class, function (Grid $grid) {

            $grid->id('编号')->sortable();
            $grid->column('title', '标题');
            $grid->column('task', '任务类');
            $grid->column('intro','介绍')->display(function($text){
                return str_limit($text, 50);
            });
            $grid->column('created_at','开始时间')->display(function($value){
                return substr($value, 0, 10);
            });
            $grid->column('updated_at','结束时间')->display(function($value){
                return substr($value, 0, 10);
            });
            
            $grid->actions(function(Actions $action){
                $action->prepend('<a title="'.$this->row->intro.'" href="'. route('execute.index',['task_id'=>$action->getKey()]).'"><i class="fa fa-eye"></i></a>');
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Task::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title', '标题');
            $form->text('task','任务类')->default('BasicTask');
            $form->textarea('intro', '介绍');
            $form->date('created_at', '开始时间');
            $form->date('updated_at', '结束时间');
            
            $form->hasMany('nodes', '节点',function(NestedForm $sub){
                $sub->text('expression', '表达式');
                $sub->date('begin_at','开始时间');
                $sub->date('end_at', '结束时间');
            });

        });
    }
}
