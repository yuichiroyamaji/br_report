<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return voido
     */
    public function run()
    {
        //Model::unguard();
        $this->call(UsersTableSeeder::class);
    }
}
