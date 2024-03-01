<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::where('short_name', 'FUTO')->firstOrFail();

        $user1 = new User;
        $user1->first_name = 'Christian';
        $user1->last_name = 'Nwadike';
        $user1->email = 'student1@rms.com';
        $user1->is_student = true;
        $user1->registration_no = '20181599321';
        $user1->password = bcrypt('password');
        $user1->save();

        $student1 = new Student;
        $student1->user_id = $user1->id;
        $student1->school_id = $school->id;
        $student1->department = 'Electrical and Electronics Engineering';
        $student1->date_of_entry = '2008-09-20';
        $student1->mode_of_entry = 'UME';
        $student1->save();

        $user2 = new User;
        $user2->first_name = 'Kelechi';
        $user2->last_name = 'Okorie';
        $user2->email = 'student2@rms.com';
        $user2->is_student = true;
        $user2->registration_no = '20181599322';
        $user2->password = bcrypt('password');
        $user2->save();

        $student2 = new Student;
        $student2->user_id = $user2->id;
        $student2->school_id = $school->id;
        $student2->department = 'Electrical and Electronics Engineering';
        $student2->date_of_entry = '2008-09-20';
        $student2->mode_of_entry = 'UME';
        $student2->save();

        $user3 = new User;
        $user3->first_name = 'Eberechi';
        $user3->last_name = 'Ahams';
        $user3->email = 'student3@rms.com';
        $user3->is_student = true;
        $user3->registration_no = '20181599323';
        $user3->password = bcrypt('password');
        $user3->save();

        $student3 = new Student;
        $student3->user_id = $user3->id;
        $student3->school_id = $school->id;
        $student3->department = 'Electrical and Electronics Engineering';
        $student3->date_of_entry = '2008-09-20';
        $student3->mode_of_entry = 'UME';
        $student3->save();
    }
}
