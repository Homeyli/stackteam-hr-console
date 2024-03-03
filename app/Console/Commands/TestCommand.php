<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Tnt\ConsoleTable\Table;
use Oak\Contracts\Console\OutputInterface;



class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

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
        $this->table(['#id','Firstname','Lastname'],[
            ['1','Mehdi','Homeily'],
            ['1','amir','askari']
        ]);
    }
}
