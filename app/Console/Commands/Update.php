<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        $file = file(resource_path('6160062162713_attlog.dat'));
        foreach ($file as $key => $value) {
            $file[$key] = explode("\t",ltrim($value)); 
        }

        print_r($file);
    }
}
