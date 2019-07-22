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
                'name'           => '美咲',
                'email'          => 'Y.071081010622@icloud.com',
                'password'       => 'misaki',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => 'システム管理者',
                'email'          => 'yuichiroyamaji@hotmail.com',
                'password'       => 'admin',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => 'イリヤ',
                'email'          => 'iriya@br.com',
                'password'       => 'iriya',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => 'カナ',
                'email'          => 'kana@br.com',
                'password'       => 'kana',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => '柘榴',
                'email'          => 'zakuro@br.com',
                'password'       => 'zakuro',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => 'カーマ',
                'email'          => 'kalma@br.com',
                'password'       => 'kalma',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => 'ののか',
                'email'          => 'nonoka@br.com',
                'password'       => 'nonoka',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => 'ことみ',
                'email'          => 'kotomi@br.com',
                'password'       => 'kotomi',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => 'ヒメ',
                'email'          => 'hime@br.com',
                'password'       => 'hime',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => '弓月',
                'email'          => 'yuzuki@br.com',
                'password'       => 'yuzuki',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],[
                'name'           => 'ロキ',
                'email'          => 'roki@br.com',
                'password'       => 'roki',
                'remember_token' => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => null
            ],
        ];
        DB::table('users')->truncate();
        DB::table('users')->insert($data);
    }
}
