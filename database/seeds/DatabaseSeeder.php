<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();

        // $this->call(UsersTableSeeder::class);
        $this->call(IdBindCustomerSeeder::class);
        $this->call(IdBindRecSeeder::class);
        //$this->call(FacIdBindCorpSeeder::class);
        //$this->call(FacIdBindRecSeeder::class);
        $this->call(ConstManagerSeeder::class);
        //Model::unguard();
    }
}
