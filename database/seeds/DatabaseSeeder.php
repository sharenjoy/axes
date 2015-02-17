<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeding.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $this->call('Sharenjoy\Cmsharenjoy\Seeds\UserTable');
        $this->call('Sharenjoy\Cmsharenjoy\Seeds\SettingsSeeder');
        $this->call('Sharenjoy\Cmsharenjoy\Seeds\FileFoldersSeeder');
        
        $this->command->info('All Tables Seeded');
    }

}