<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Personnel;
use App\Models\Traffic;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $this->table(['code','name','family'],[
        //     [1,'mahdi','homeily'],
        //     [2,'amir','askari']
        // ]);

        // get personnels data ----------------------------------------------
        $_personnels = Personnel::select(['id','devicecode'])->get();
        $personnels = [];

        foreach ($_personnels as $key => $value) {
            $personnels[$value['devicecode']] = $value['id']; 
        }
        unset($_personnels);
        // end get personnels data -----------------------------------------

        // read file -------------------------------------------------------
        $file = file(resource_path('6160062162713_attlog.dat'));
        $data = [];

        foreach ($file as $key => $value) {

            $record = explode("\t",ltrim($value)); 

            if (!isset($personnels[$record[0]])) {

                if($_p = Personnel::create([
                    'en_name' => 'Unknow',
                    'devicecode' => $record[0],
                    'salary' => '0'
                ])) {

                    $personnels[$record[0]] = $_p->id;
                }
            }

            $personnel_id = $personnels[$record[0]];
            $fingred_at = $record[1];

            $_record = ['personnel_id' => $personnel_id,'fingred_at' => $fingred_at];
            
            if($traffic = Traffic::updateOrCreate($_record,$_record)) {
                $this->info('One Record added');
            }

            array_push($data,$_record); 
        }

        // end read file -----------------------------------------------------

        print_r($data);die();


        
    }
}
