<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\School;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::where('short_name', 'FUTO')->firstOrFail();

        $user1 = User::updateOrCreate(
            [
                'email' => 'result-compiler@futo.com',
                'phone_no' => '07033793094',
            ],
            [
                'first_name' => 'Macqueen',
                'last_name' => 'Chukwuma',
                'is_staff' => true,
                'password' => bcrypt('password'),
            ]
        );

        $staff1 = Staff::updateOrCreate(
            [
                'user_id' => $user1->id,
            ],
            [
                'school_id' => $school->id,
                'date_of_entry' => '2008-09-21',
            ]
        );

        $resultCompilingOfficer = Role::where('key', 'result-compiling-officer')->firstOrFail();

        $user1->roles()->attach($resultCompilingOfficer->id);

        $user2 = User::updateOrCreate(
            [
                'email' => 'checking-compiler@futo.com',
                'phone_no' => '07033793204',
            ],
            [
                'first_name' => 'Joe',
                'last_name' => 'Malaky',
                'is_staff' => true,
                'password' => bcrypt('password'),
            ]
        );

        $staff2 = Staff::updateOrCreate(
            [
                'user_id' => $user2->id,
            ],
            [
                'school_id' => $school->id,
                'date_of_entry' => '2008-09-21',
            ]
        );

        $checkingOfficer = Role::where('key', 'checking-officer')->firstOrFail();

        $user2->roles()->attach($checkingOfficer->id);

        $user3 = User::updateOrCreate(
            [
                'email' => 'recommending-officer@futo.com',
                'phone_no' => '08033793094',
            ],
            [
                'first_name' => 'Chinenye',
                'last_name' => 'Obiakor',
                'is_staff' => true,
                'password' => bcrypt('password'),
            ]
        );

        $staff3 = Staff::updateOrCreate(
            [
                'user_id' => $user3->id,
            ],
            [
                'school_id' => $school->id,
                'date_of_entry' => '2008-09-21',
            ]
        );

        $recommendingOfficer = Role::where('key', 'recommending-officer')->firstOrFail();

        $user3->roles()->attach($recommendingOfficer->id);

        $user4 = User::updateOrCreate(
            [
                'email' => 'approving-officer@futo.com',
                'phone_no' => '07033093204',
            ],
            [
                'first_name' => 'Bosah',
                'last_name' => 'Chukwuogoh',
                'is_staff' => true,
                'password' => bcrypt('password'),
            ]
        );

        $staff4 = Staff::updateOrCreate(
            [
                'user_id' => $user4->id,
            ],
            [
                'school_id' => $school->id,
                'date_of_entry' => '2008-09-21',
            ]
        );

        $approvingOfficer = Role::where('key', 'approving-officer')->firstOrFail();

        $user4->roles()->attach($approvingOfficer->id);

        $user5 = User::updateOrCreate(
            [
                'email' => 'school-admin@futo.com',
                'phone_no' => '07038563094',
            ],
            [
                'first_name' => 'Malaika',
                'last_name' => 'Onwuchekwa',
                'is_staff' => true,
                'password' => bcrypt('password'),
            ]
        );

        $staff5 = Staff::updateOrCreate(
            [
                'user_id' => $user1->id,
            ],
            [
                'school_id' => $school->id,
                'date_of_entry' => '2008-09-21',
            ]
        );

        $schoolAdmin = Role::where('key', 'school-admin')->firstOrFail();

        $user5->roles()->attach($schoolAdmin->id);

        $user6 = User::updateOrCreate(
            [
                'email' => 'result-uploader@futo.com',
                'phone_no' => '09033793204',
            ],
            [
                'first_name' => 'Christian',
                'last_name' => 'Onyeso',
                'is_staff' => true,
                'password' => bcrypt('password'),
            ]
        );

        $staff6 = Staff::updateOrCreate(
            [
                'user_id' => $user2->id,
            ],
            [
                'school_id' => $school->id,
                'date_of_entry' => '2008-09-21',
            ]
        );

        $resultUploader = Role::where('key', 'result-uploader')->firstOrFail();

        $user6->roles()->attach($resultUploader->id);

        $user7 = User::updateOrCreate(
            [
                'email' => 'dispatching-officer@futo.com',
                'phone_no' => '07030943094',
            ],
            [
                'first_name' => 'Ayo',
                'last_name' => 'Bursari',
                'is_staff' => true,
                'password' => bcrypt('password'),
            ]
        );

        $staff7 = Staff::updateOrCreate(
            [
                'user_id' => $user7->id,
            ],
            [
                'school_id' => $school->id,
                'date_of_entry' => '2008-09-21',
            ]
        );

        $dispatchingOfficer = Role::where('key', 'dispatching-officer')->firstOrFail();

        $user7->roles()->attach($dispatchingOfficer->id);
    }
}
