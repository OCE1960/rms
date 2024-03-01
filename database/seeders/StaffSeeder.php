<?php

namespace Database\Seeders;

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
            ],
            [
                'first_name' => 'Macqueen',
                'last_name' => 'Chukwuma',
                'phone_no' => '07033793094',
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

        $resultCompiler = Role::where('key', 'result-compiler')->firstOrFail();

        $user1->roles()->attach($resultCompiler->id);

        $user2 = User::updateOrCreate(
            [
                'email' => 'checking-compiler@futo.com',
            ],
            [
                'first_name' => 'Joe',
                'last_name' => 'Malaky',
                'phone_no' => '07033793204',
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
    }
}
