<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    User::create([
		    'name' => 'Master Chef',
		    'email' => 'master@chef.com',
		    'password' => bcrypt('test@123$'),
	    ]);
    }
}
