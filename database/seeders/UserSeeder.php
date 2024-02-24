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

        $user1->roles()->attach($superAdmin->id);

        $user2 = new User;
        $user2->first_name = 'Macqueen';
        $user2->last_name = 'Chukwuma';
        $user2->email = 'manager@rms.com';
        $user2->phone_no = '07033793213';
        $user1->is_staff = true;
        $user2->password = bcrypt('password');
        $user2->save();

        $resultCompiler = Role::where('key', 'result-compiler')->firstOrFail();

        $user2->roles()->attach($resultCompiler->id);

        $user3 = new User;
        $user3->first_name = 'Aruni';
        $user3->last_name = 'Samuel';
        $user3->email = 'staff@rms.com';
        $user3->phone_no = '07033022383';
        $user1->is_staff = true;
        $user3->password = bcrypt('password');
        $user3->save();

        $checkingOfficer = Role::where('key', 'checking-officer')->firstOrFail();

        $user3->roles()->attach($checkingOfficer->id);
    }
}