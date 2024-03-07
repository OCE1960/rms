<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = new Role;
        $superAdmin->key = 'super-admin';
        $superAdmin->label = 'Super Admin';
        $superAdmin->save();

        $superAdmin = new Role;
        $superAdmin->key = 'registry';
        $superAdmin->label = 'Registry';
        $superAdmin->save();

        $student = new Role;
        $student->key = 'student';
        $student->label = 'Student';
        $student->save();

        $resultEnquirer = new Role;
        $resultEnquirer->key = 'result-enquirer';
        $resultEnquirer->label = 'Result Enquirer';
        $resultEnquirer->save();

        $resultEnquirer = new Role;
        $resultEnquirer->key = 'result-compiling-officer';
        $resultEnquirer->label = 'Result Compiling Officer';
        $resultEnquirer->save();

        $checkingOfficer = new Role;
        $checkingOfficer->key = 'checking-officer';
        $checkingOfficer->label = 'Checking Officer';
        $checkingOfficer->save();

        $recommendingOfficer = new Role;
        $recommendingOfficer->key = 'recommending-officer';
        $recommendingOfficer->label = 'Recommending Officer';
        $recommendingOfficer->save();

        $approvingOfficer = new Role;
        $approvingOfficer->key = 'approving-officer';
        $approvingOfficer->label = 'Approving Officer';
        $approvingOfficer->save();

        $schoolAdmin = new Role;
        $schoolAdmin->key = 'school-admin';
        $schoolAdmin->label = 'School Admin';
        $schoolAdmin->save();

        $resultUploader = new Role;
        $resultUploader->key = 'result-uploader';
        $resultUploader->label = 'Result Uploader';
        $resultUploader->save();

        $dispatchingOfficer = new Role;
        $dispatchingOfficer->key = 'dispatching-officer';
        $dispatchingOfficer->label = 'Dispatching Officer';
        $dispatchingOfficer->save();
    }
}
