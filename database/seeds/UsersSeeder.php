<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'username' => 'Administrator',
        	'email'    => 'admin@admin.com',
        	'password' => bcrypt('admin'),
        	'is_admin' => true ]);
    }
}
