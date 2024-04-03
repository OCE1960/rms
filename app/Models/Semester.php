<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_id', 'semester_session', 'created_by', 'semester_name', 'updated_by'
    ];

    public function studentSemesterResult($userId)
    {
        return AcademicResult::where('semester_id', $this->id)->where('user_id', $userId)->get();
    }

    public function studentSemesterTotalCourseUnit($userId)
    {
        return AcademicResult::where('semester_id', $this->id)->where('user_id', $userId)
         ->sum('unit');
    }

    public function studentSemesterTotalGradePoint($userId)
    {
        return AcademicResult::where('semester_id', $this->id)->where('user_id', $userId)
         ->sum('grade_point');
    }

    public function semesters()
    {
        return $this->hasMany(AcademicResult::class, 'school_id', 'id');
    }
}
