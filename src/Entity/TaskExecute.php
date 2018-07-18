<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OkamiChen\TmsTask\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of TaskNode
 * @date 2018-6-5 18:29:40
 * @author dehua
 */
class TaskExecute extends Model {

    
    protected $table    = 'task_execute';
    
    protected $fillable = [
        'task_id','node_id','start_at'
    ];


    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }
    
    public function node(){
        return $this->belongsTo(TaskNode::class, 'node_id');
    }
    
    /**
     * 获取执行类
     * @return \Ue\Task\BasicTask
     */
    public function getExecute(){
        $class  = config('tms-task-config.task.class') . $this->task->task;
        if(!class_exists($class)){
            throw new Exception($class .' Not Found.');
        }
        return new $class($this->task, $this->node);
    }
    
    /**
     * 执行任务
     * @return true
     */
    public function run(){
        return $this->getExecute()->run();
    }
    
}
