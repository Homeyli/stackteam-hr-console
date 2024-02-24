<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Personnel;


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
        $_personnels = Personnel::select(['id','devicecode','en_name'])->where('is_active',true)->get();
    
    }
}
