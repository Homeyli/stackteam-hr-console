<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Personnel;

class AddPersonnel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:personnel';

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
        $en_name = $this->ask('enter english name');
        $device_code = $this->ask("enter Device code for $en_name");

        $salary = $this->ask("enter salary for $en_name") / 1000000;

        if(Personnel::create([
            'en_name' => $en_name,
            'devicecode' => $device_code,
            'salary' => $salary
        ])) {

            $this->info('Personnel added');
        }

        
    }
}
