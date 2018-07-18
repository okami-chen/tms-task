<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OkamiChen\TmsTask\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Description of TaskNode
 * @date 2018-6-5 18:29:40
 * @author dehua
 */
class TaskNode extends Model {
    
    protected $table    = 'task_node';
    
    protected $fillable = [
        'task_id','expression','begin_at','end_at'
    ];
    
    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }
    
}
