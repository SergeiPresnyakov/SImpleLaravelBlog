<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'name' => 'Author unkown',
                'email' => 'unknown@author.com',
                'password' => bcrypt(str_random(16))
            ],
            [
                'name' => 'Author',
                'email' => 'authoremail@gmail.com',
                'password' => bcrypt('123123')
            ]
        ];

        DB::table('users')->insert($data);
    }
}
