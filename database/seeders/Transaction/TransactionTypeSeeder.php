<?php

namespace Database\Seeders\Transaction;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
//            ['title'=>'Santa','max_payment'=>50000000,'min_payment'=>15000000,'max_time'=>'00:20:00'],
            ['title'=>'Paya','max_payment'=>99999999,'min_payment'=>0,'max_time'=>null],
            ['title'=>'Internal','max_payment'=>null,'min_payment'=>null,'max_time'=>null],
        ];

        foreach ($items as $item){
            DB::table('transaction_type')
                ->insert($item);
        }
    }
}
