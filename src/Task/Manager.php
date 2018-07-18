<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace OkamiChen\TmsTask\Task;

use Cron\CronExpression;

/**
 * Description of Manager
 * @date 2018-6-5 18:06:51
 * @author dehua
 */
class Manager {

    /**
     * 
     * @param type $cron
     * @param type $start
     * @param type $end
     */
    static public function run($cron, $start, $end){
        
        $cron = CronExpression::factory($cron);

        $rows = $cron->getMultipleRunDates(1000, $start);
        $result = [];
        $finish = strtotime($end) + 86400;
        if(!count($rows)){
            return $result;
        }
        
        $now    = time();

        foreach ($rows as $key => $row) {
            
            $date   = $row->format('Y-m-d H:i:').'00';
            $cur    = strtotime($date);
            
            if($cur <= $now){
                continue;
            }
            
            if($cur >= $finish){
                break;
            }
            $result[] = $date;
        }
        return $result;
    }
}
