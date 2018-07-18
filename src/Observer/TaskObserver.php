<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OkamiChen\TmsTask\Observer;

/**
 * Description of TaskObserver
 * @date 2018-6-21 17:47:15
 * @author dehua
 */
class TaskObserver {

    public function deleting($model){
        
        $nodes  = $model->nodes;
        if(count($nodes)){
            foreach ($nodes as $key => $node) {
                $node->delete();
            }
        }
        
        $executes   = $model->executes;
        if(count($executes)){
            foreach ($executes as $key => $execute) {
                $execute->delete();
            }
        }
    }
}
