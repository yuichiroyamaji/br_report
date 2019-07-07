<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'           => 'yoshie',
                'email'          => 'Y.071081010622@icloud.com',
                'password'       => 'yoshie',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => 'yuichiro',
                'email'          => 'yuichiroyamaji@hotmail.com',
                'password'       => 'yuichiro',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],
        ];
        DB::table('users')->truncate();
        DB::table('users')->insert($data);
    }
}
