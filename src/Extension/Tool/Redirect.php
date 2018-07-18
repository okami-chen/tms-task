<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OkamiChen\TmsTask\Extension\Tool;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;

/**
 * Description of UserGender
 * @date 2018-6-6 10:31:50
 * @author dehua
 */
class Redirect extends AbstractTool {

    protected $url;
    
    protected function script() {

        return <<<EOT
$('#page_task').click(function(){
    window.location.href = '{$this->url}';
                
});                

EOT;
    }

    public function render() {
        
        Admin::script($this->script());

        return view('tms-task::task.redirect');
    }
    
    public function setUrl($url){
        $this->url  = $url;
    }

}
