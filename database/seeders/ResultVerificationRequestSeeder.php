<?php

namespace Database\Seeders;

use App\Models\ResultVerificationRequest;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResultVerificationRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::where('short_name', 'FUTO')->firstOrFail();
        $user = User::where('email', 'md@asonic.com')->firstOrFail();

        ResultVerificationRequest::updateOrCreate(
            [
                'enquirer_user_id' => $user->id,
                'school_id' => $school->id,
            ],
            [
                'Student_first_name' => 'Christian',
                'student_last_name' => 'Nwadike',
                'registration_no' => '20181599321',
            ]
        );
    }
}
