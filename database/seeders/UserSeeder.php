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
        $user1->name = 'Okeke Chukwuemeka';
        $user1->email = 'admin@hrms.com';
        $user1->phone_no = '07033792383';
        $user1->password = bcrypt('password');
        $user1->save();

        $superAdmin = Role::where('key', 'super-admin')->firstOrFail();

        $user1->roles()->attach($superAdmin->id);

        $user2 = new User;
        $user2->name = 'Chukwuma Macqueen';
        $user2->email = 'manager@hrms.com';
        $user2->phone_no = '07033793213';
        $user2->password = bcrypt('password');
        $user2->save();

        $resultCompiler = Role::where('key', 'result-compiler')->firstOrFail();

        $user2->roles()->attach($resultCompiler->id);

        $user3 = new User;
        $user3->name = 'Aruni Yusuf Samuel';
        $user3->email = 'staff@hrms.com';
        $user3->phone_no = '07033022383';
        $user3->password = bcrypt('password');
        $user3->save();

        $checkingOfficer = Role::where('key', 'checking-officer')->firstOrFail();

        $user3->roles()->attach($checkingOfficer->id);
    }
}
