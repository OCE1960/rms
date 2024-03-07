<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\TaskAssignment;
use App\Models\TranscriptRequest;
use App\Models\User;
use App\Models\WorkItem;
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
        $registry = User::where('email', 'registry@rms.com')->firstOrFail();

        $transcriptRequest = TranscriptRequest::updateOrCreate(
            [
                'user_id' => $user->id,
                'school_id' => $school->id,
            ],
            [
                'send_by' => 'mail',
                'destination_country' => 'United Kingdon',
                'receiving_institution' => 'University of Bolton',
                'program' => $user->student?->department,
                'title_of_request' => 'Transcript for WES Evaluation',
                'reason_for_request' => 'I am Request for my WES Evaluation for Canada Express Entry',
            ]
        );

        $workItem = WorkItem::updateOrCreate(
            [
                'transcript_request_id' => $transcriptRequest->id,
            ],
            [
                'is_completed' => false,
            ]
        );

        TaskAssignment::updateOrCreate(
            [
                'work_item_id' => $workItem->id,
            ],
            [
                'send_by' => $user->id,
                'send_to' => $registry->id,
            ]
        );
    }
}
