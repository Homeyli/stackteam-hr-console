<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Personnel;
use App\Models\Traffic;

class CalcSalary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:salary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $_personnels = Personnel::where('is_active',true)->get();

        $personnelList = [];
        $personnelObject = [];

        foreach ($_personnels as $k => $personnel) {

            $strName = "$personnel->en_name\t#$personnel->devicecode";
            $personnelList[$personnel->id] = $strName;
            $personnelObject[$strName] = $personnel;
        }

        //print_r($personnelList);die();
        $selected_pesonnel = $this->choice("select the personnel : ",$personnelList);

        unset($_personnels);
        unset($personnelList);

        //print_r($personnelObject[$selected_pesonnel]->toArray());die();
        
        $this->calcSalary($personnelObject[$selected_pesonnel]);


    }

    private function calcSalary(Personnel $personnel) {

        // get all traffics
        //die('#' . $personnel->id);
        $_trafficList = Traffic::where('personnel_id',$personnel->id)->get();

        //print_r($traffic->toArray());die();
        $trafficDateList = [];
        //$traffic = 
        foreach ($_trafficList as $k => $traffic) {

            $dateTime = explode(' ',$traffic->fingred_at);

            if(!isset($trafficDateList[$dateTime[0]])) {
                $trafficDateList[$dateTime[0]] = [];
            }
            
            array_push($trafficDateList[$dateTime[0]],$dateTime[1]);
        }

        $tableHeader = ['#','Date','Entry','Exit'];
        $tableRecords = [];

        // $this->table(['code','name','family'],[
        //     [1,'mahdi','homeily'],
        //     [2,'amir','askari']
        // ]);
        
        $counter = 1;
        foreach ($trafficDateList as $date => $times) {
            $record = [$counter++,$date];
            $record = array_merge($record,$times);

            array_push($tableRecords,$record);
        }

        //print_r($tableRecords);die();

        $this->table($tableHeader,$tableRecords);
        
    }

}
