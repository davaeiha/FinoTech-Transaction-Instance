<?php

namespace Database\Seeders;

use Database\Seeders\Bank\BankSeeder;
use Database\Seeders\Client\ClientSeeder;
use Database\Seeders\Transaction\TransactionTypeSeeder;
use Database\Seeders\User\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            BankSeeder::class,
            TransactionTypeSeeder::class,
            ClientSeeder::class
        ];


        if (App::environment('local')){
            $seeders = array_merge($seeders,[
                UserSeeder::class,
            ]);
        }

        $this->call($seeders);
    }
}
