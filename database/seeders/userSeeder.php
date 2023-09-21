<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'admin1',
            'email' => 'coba@gmail.com',
            'role_code' => 'admin',
            'password' => bcrypt('admin1234')
        ]);
        
        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'cobalagi@gmail.com',
            'role_code' => 'free-user',
            'password' => bcrypt('user1234')
        ]);
    }
}
