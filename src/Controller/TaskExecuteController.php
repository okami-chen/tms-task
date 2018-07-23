<?php

namespace OkamiChen\TmsTask\Controller;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use OkamiChen\TmsTask\Entity\TaskExecute;
use OkamiChen\TmsTask\Entity\Task;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Grid\Tools;
use OkamiChen\TmsTask\Extension\Tool\Redirect;

class TaskExecuteController extends Controller
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

            $content->header('任务流管理');
            $content->description('');

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

            $content->header('任务流管理');
            $content->description('');

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

            $content->header('任务流管理');
            $content->description('');

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
        return Admin::grid(TaskExecute::class, function (Grid $grid) {

            $grid->id('编号')->sortable();
            $grid->column('task_id','任务编号')->sortable();
            $grid->column('task.title', '标题');
            $grid->column('node_id','节点编号')->sortable();
            $grid->column('task.week', '星期')->display(function($text){
                return date('w', strtotime($this->start_at));
            });
            $grid->column('node.expression', '表达式');
            $grid->column('start_at', '执行')->sortable();
            
            $grid->filter(function(Filter $filter){
                $filter->disableIdFilter();
                $options    = Task::pluck('title','id');
                $filter->equal('task_id', '任务')->select($options);
                $filter->between('start_at', '时间')->date();
            });
            
            $grid->tools(function (Tools $tools) {
                $redirect   = new Redirect();
                $redirect->setUrl(route('tms.default.index'));
                $tools->append($redirect);
            });
            
            $grid->model()->orderBy('start_at','asc');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(TaskExecute::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->datetime('start_at', '执行时间');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
