<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('production')) {
            return;
        }

        switch (app()->environment()) {
            case 'local':
                $this->call([
                    DevNodeSeeder::class,
                    DemoSeeder::class,
                ]);
                break;
            case 'testing':
            case 'staging':
                $this->call([
                    DevNodeSeeder::class,
                ]);
                break;
        }
    }
}
