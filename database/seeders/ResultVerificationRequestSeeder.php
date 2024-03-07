<?php

namespace Database\Seeders;

use App\Models\ResultVerificationRequest;
use App\Models\School;
use App\Models\TaskAssignment;
use App\Models\User;
use App\Models\WorkItem;
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
        $registry = User::where('email', 'registry@rms.com')->firstOrFail();

        $resultVerificationRequest = ResultVerificationRequest::updateOrCreate(
            [
                'enquirer_user_id' => $user->id,
                'school_id' => $school->id,
            ],
            [
                'Student_first_name' => 'Christian',
                'student_last_name' => 'Nwadike',
                'registration_no' => '20181599321',
                'title_of_request' => 'Evaluation for Scholarship',
                'reason_for_request' => 'We are requesting to evaluate the validity of his credentials for Chevening Scholarship',
            ]
        );

        $workItem = WorkItem::updateOrCreate(
            [
                'result_verification_request_id' => $resultVerificationRequest->id,
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
