<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    use HasUuids;

    public function studentSemesterResult($userId)
    {
        return AcademicResult::where('semester_id', $this->id)->where('user_id', $userId)->get();
    }

    public function studentSemesterTotalCourseUnit($userId)
    {
        return AcademicResult::where('semester_id', $this->id)->where('user_id', $userId)
        ->sum('grade_point');
    }

    public function studentSemesterTotalGradePoint($userId)
    {
        return AcademicResult::where('semester_id', $this->id)->where('user_id', $userId)
        ->sum('grade_point');
    }
}
