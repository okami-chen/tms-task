<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OkamiChen\TmsTask\Task;

use OkamiChen\TmsTask\Entity\Task;
use OkamiChen\TmsTask\Entity\TaskNode;

/**
 * Description of BasicTask
 * @date 2018-6-5 18:53:56
 * @author dehua
 */
class BasicTask {

    /**
     *
     * @var \Ue\Entity\Task 
     */
    protected $task;

    /**
     *
     * @var \Ue\Entity\TaskNode 
     */
    protected $node;

    public function __construct(Task $task, TaskNode $node) {
        $this->task = $task;
        $this->node = $node;
    }

    public function run() {

        $message = [
            '标题: ' . $this->task->title,
            '简介: ' . $this->task->intro,
        ];

        ding(implode("\r\n", $message));
    }

}
