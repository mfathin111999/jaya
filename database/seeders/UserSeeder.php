<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	[
	            'name' => 'Nurani Rezeki Unggul',
	            'email' => 'nru@gmail.com',
	            'username' => 'nru',
	            'password' => Hash::make('123456789'),
	            'role' => 1,
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
	            'name' => 'mandor1',
	            'email' => 'mandor1@gmail.com',
	            'username' => 'mandor1',
	            'password' => Hash::make('123456789'),
	            'role' => 3,
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
	            'name' => 'vendor1',
	            'email' => 'vendor1@gmail.com',
	            'username' => 'vendor1',
	            'password' => Hash::make('123456789'),
	            'role' => 5,
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
	            'name' => 'vendor2',
	            'email' => 'vendor2@gmail.com',
	            'username' => 'vendor2',
	            'password' => Hash::make('123456789'),
	            'role' => 5,
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
	            'name' => 'vendor3',
	            'email' => 'vendor3@gmail.com',
	            'username' => 'vendor3',
	            'password' => Hash::make('123456789'),
	            'role' => 5,
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
	            'name' => 'surveyer1',
	            'email' => 'surveyer1@gmail.com',
	            'username' => 'surveyer1',
	            'password' => Hash::make('123456789'),
	            'role' => 2,
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
	            'name' => 'surveyer2',
	            'email' => 'surveyer2@gmail.com',
	            'username' => 'surveyer2',
	            'password' => Hash::make('123456789'),
	            'role' => 2,
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
	            'name' => 'surveyer3',
	            'email' => 'surveyer3@gmail.com',
	            'username' => 'surveyer3',
	            'password' => Hash::make('123456789'),
	            'role' => 2,
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
