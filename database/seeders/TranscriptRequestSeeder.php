<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\TranscriptRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class TranscriptRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::where('short_name', 'FUTO')->firstOrFail();
        $user = User::where('email', 'student1@rms.com')->firstOrFail();

        TranscriptRequest::updateOrCreate(
            [
                'user_id' => $user->id,
                'school_id' => $school->id,
            ],
            [
                'send_by' => 'mail',
                'type' => 'mail',
                'destination_country' => 'United Kingdon',
                'receiving_institution' => 'University of Bolton',
                'program' => $user->student?->department,
            ]
        );
    }
}
