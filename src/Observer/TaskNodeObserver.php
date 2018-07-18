<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OkamiChen\TmsTask\Observer;

use OkamiChen\TmsTask\Entity\TaskExecute;
use OkamiChen\TmsTask\Task\Manager;

/**
 * Description of TaskNodeObserver
 * @date 2018-6-5 18:42:05
 * @author dehua
 */
class TaskNodeObserver {

    public function saved($model){

        $start  = $model->begin_at;
        $end    = $model->end_at;
        $cron   = $model->expression;
        
        $rows   = Manager::run($cron, $start, $end);
        
        if(!count($rows)){
            return $model;
        }
        
        TaskExecute::where(['node_id'=>$model->id])->delete();
        
        foreach ($rows as  $key => $row){
            
            $values   = [
                'task_id'   => $model->task_id,
                'node_id'   => $model->id,
                'start_at'  => $row,
            ];
            
            TaskExecute::create($values);
        }

        return $model;
    }
    
    public function deleted($model){
        TaskExecute::where(['node_id'=>$model->id])->delete();
    }

}
