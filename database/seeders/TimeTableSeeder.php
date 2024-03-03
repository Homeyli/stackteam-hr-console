<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('time_tables')->insert([
            // year 1402;
            // M: 1
            [
                'year' => 1402,
                'month' => 1,
                'totaldays' => 31,
                'fridays' => 4,
                'holidays' => 6,
                'workdays' => 21,
                'totalhours' => 154,
            ],
            // M: 2
            [
                'year' => 1402,
                'month' => 2,
                'totaldays' => 31,
                'fridays' => 5,
                'holidays' => 3,
                'workdays' => 21,
                'totalhours' => 169,
            ],
            // M: 3
            [
                'year' => 1402,
                'month' => 3,
                'totaldays' => 31,
                'fridays' => 4,
                'holidays' => 2,
                'workdays' => 25,
                'totalhours' => 183,
            ],
            // M: 4
            [
                'year' => 1402,
                'month' => 4,
                'totaldays' => 31,
                'fridays' => 5,
                'holidays' => 1,
                'workdays' => 25,
                'totalhours' => 183,
            ],
            // M: 5
            [
                'year' => 1402,
                'month' => 5,
                'totaldays' => 31,
                'fridays' => 4,
                'holidays' => 1,
                'workdays' => 26,
                'totalhours' => 191,
            ],
            // M: 6
            [
                'year' => 1402,
                'month' => 6,
                'totaldays' => 31,
                'fridays' => 5,
                'holidays' => 3,
                'workdays' => 23,
                'totalhours' => 169,
            ],
            // M: 7
            [
                'year' => 1402,
                'month' => 7,
                'totaldays' => 30,
                'fridays' => 4,
                'holidays' => 2,
                'workdays' => 24,
                'totalhours' => 176,
            ],
            // M: 8
            [
                'year' => 1402,
                'month' => 8,
                'totaldays' => 30,
                'fridays' => 4,
                'holidays' => 0,
                'workdays' => 26,
                'totalhours' => 191,
            ],
            // M: 9
            [
                'year' => 1402,
                'month' => 9,
                'totaldays' => 30,
                'fridays' => 4,
                'holidays' => 1,
                'workdays' => 25,
                'totalhours' => 183,
            ],
            // M: 10
            [
                'year' => 1402,
                'month' => 10,
                'totaldays' => 30,
                'fridays' => 5,
                'holidays' => 0,
                'workdays' => 25,
                'totalhours' => 183,
            ],
            // M: 11
            [
                'year' => 1402,
                'month' => 11,
                'totaldays' => 30,
                'fridays' => 4,
                'holidays' => 3,
                'workdays' => 23,
                'totalhours' => 169,
            ],
            // M: 12
            [
                'year' => 1402,
                'month' => 12,
                'totaldays' => 29,
                'fridays' => 4,
                'holidays' => 2,
                'workdays' => 23,
                'totalhours' => 169,
            ],
        ]);
    }
}
