<?php

namespace Database\Seeders\Bank;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['title'=>'Keshavarzi','type'=>'0'],
            ['title'=>'Parsian','type'=>'1'],
            ['title'=>'Ayande','type'=>'1'],
        ];

        foreach ($items as $item){
            DB::table('bank')
                ->insert($item);
        }
    }
}
