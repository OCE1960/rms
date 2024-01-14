<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
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
        $admin = new Role;
        $admin->role = 'Admin';
        $admin->status = true;
        $admin->save();

        $user1 = new User;
        $user1->name = 'Okeke Chukwuemeka';
        $user1->email = 'admin@hrms.com';
        $user1->phone_no = '07033792383';
        $user1->password = bcrypt('password');
        $user1->save();

        $user1->roles()->attach($admin->id);

        $manager = new Role;
        $manager->role = 'Manager';
        $manager->status = true;
        $manager->save();

        $user2 = new User;
        $user2->name = 'Chukwuma Macqueen';
        $user2->email = 'manager@hrms.com';
        $user2->phone_no = '07033793213';
        $user2->password = bcrypt('password');
        $user2->save();

        $user2->roles()->attach($manager->id);

        $staff = new Role;
        $staff->role = 'Staff';
        $staff->status = true;
        $staff->save();

        $user3 = new User;
        $user3->name = 'Aruni Yusuf Samuel';
        $user3->email = 'staff@hrms.com';
        $user3->phone_no = '07033022383';
        $user3->password = bcrypt('password');
        $user3->save();

        $user3->roles()->attach($staff->id);

        $leaveRequest1 = new LeaveRequest;
        $leaveRequest1->user_id = $user1->id;
        $leaveRequest1->title = 'Summer Leave';
        $leaveRequest1->description = 'I kindly Request for Summer Leave';
        $leaveRequest1->start_date = '2023-10-23';
        $leaveRequest1->end_date = '2023-10-29';
        $leaveRequest1->save();

        $leaveRequest1 = new LeaveRequest;
        $leaveRequest1->user_id = $user2->id;
        $leaveRequest1->title = 'Summer Leave 2';
        $leaveRequest1->description = 'I kindly Request for Summer Leave 2';
        $leaveRequest1->start_date = '2023-10-23';
        $leaveRequest1->end_date = '2023-10-29';
        $leaveRequest1->save();

        $leaveRequest1 = new LeaveRequest;
        $leaveRequest1->user_id = $user3->id;
        $leaveRequest1->title = 'Summer Leave 3';
        $leaveRequest1->description = 'I kindly Request for Summer Leave 3';
        $leaveRequest1->start_date = '2023-10-23';
        $leaveRequest1->end_date = '2023-10-29';
        $leaveRequest1->save();
    }
}
