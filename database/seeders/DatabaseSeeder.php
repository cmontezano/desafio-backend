<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Shopkeeper;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory(10)
            ->create()
            ->each(function ($customer) {
                $customer->user()->save(User::factory()->make());
            });

        Shopkeeper::factory(10)
            ->create()
            ->each(function ($shopkeeper) {
                $shopkeeper->user()->save(User::factory()->make());
            });
    }
}
