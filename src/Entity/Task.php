<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OkamiChen\TmsTask\Entity;

use Illuminate\Database\Eloquent\Model;
use OkamiChen\TmsTask\Entity\TaskNode;
use OkamiChen\TmsTask\Entity\TaskExecute;

/**
 * Description of Task
 * @date 2018-6-5 17:55:09
 * @author dehua
 */
class Task extends Model {
    
    protected $table    = 'task';
    
    
    public function nodes(){
        return $this->hasMany(TaskNode::class, 'task_id');
    }
    
    public function executes(){
        return $this->hasMany(TaskExecute::class, 'task_id');
    }
}
