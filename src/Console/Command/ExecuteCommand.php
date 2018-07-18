<?php

namespace OkamiChen\TmsTask\Console\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use OkamiChen\TmsTask\Entity\TaskExecute;

class ExecuteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tms:task:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '任务提醒推送';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->addArgument('id', InputArgument::OPTIONAL, '必须填写');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $id = $this->argument('id');
        
        if($id){
            $this->doRun($id);
            return true;
        }
        
        $times  = [
            date('Y-m-d H:i:00', time() + 180),
            date('Y-m-d H:i:00', time() + 300),
        ];
        
        foreach ($times as $k => $v){
            $this->line('time<=>'.$v);
        }

        $rows   = TaskExecute::whereIn('start_at',[$times])->get();
        if(!count($rows)){
            return true;
        }
        
        foreach ($rows as $key => $row) {
            $this->doRun($row->id);
        }

    }
    
    protected function doRun($id){
        
        $execute    = TaskExecute::find($id);
        
        if(!$execute){
            $this->line('未找到');
            return true;
        }
        
        $exec     = $execute->getExecute();
        $response = $exec->run();
        $execute->delete();
        return $response;
    }
}
