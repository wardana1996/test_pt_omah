<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $references = [
            [
                'name'	=> "user1",
                'email'	=> "user1@gmail.com",
                'password'	=> bcrypt('12345'),
            ],
            [
                'name'	=> "user1",
                'email'	=> "user2@gmail.com",
                'password'	=> bcrypt('678910')
            ],
            [
                'name'	=> "user3",
                'email'	=> "user3@gmail.com",
                'password'	=> bcrypt('1112131415')
            ],
            [
                'name'	=> "user4",
                'email'	=> "user4@gmail.com",
                'password'	=> bcrypt('1617181920')
            ]
        ];

        \DB::table('users')->insert($references);
    }
}
