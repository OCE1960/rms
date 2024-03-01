<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user1 = new User;
        $user1->first_name = 'Chukwuemeka';
        $user1->last_name = 'Okeke';
        $user1->email = 'admin@rms.com';
        $user1->phone_no = '07033792383';
        $user1->is_staff = true;
        $user1->password = bcrypt('password');
        $user1->save();

        $superAdmin = Role::where('key', 'super-admin')->firstOrFail();
    }
}