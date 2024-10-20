<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email', 'password', 'first_name', 'middle_name', 'last_name', 'email',
        'registration_no', 'phone_no', 'gender', 'profile_picture_path', 'ordinal', 'title',
        'is_disabled', 'is_student', 'is_staff', 'is_result_verifier', 'is_account_activated',
        'is_first_login', 'email_verified_at', 'state_of_origin', 'date_of_entry',
        'nationality', 'school_id', 'date_of_birth', 'created_by', 'updated_by'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    public function adminlte_desc()
    {
        return 'That\'s a nice guy';
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole($role_id)
    {
        foreach($this->roles()->get() as $user_role)
        {
            if($user_role->id == $role_id)
            {
                return true;
            }
        }

        return false;
    
    }

    protected function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->last_name .', '.$this->first_name . ' ' . $this->middle_name,
        );
    }

    public function assignTasks()
    {
        return $this->hasMany(TaskAssignment::class, 'send_to', 'id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'user_id', 'id');
    }

    public function assignedTaskCount()
    {
        return TaskAssignment::where('send_to', $this->id)->where('is_task_completed', false)->count();
    }

    public function academicResults()
    {
        return $this->hasMany(AcademicResult::class, 'user_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function enquirer()
    {
        return $this->hasOne(Enquirer::class, 'user_id', 'id');
    }

     /**
     * Scope a query to only include popular users.
     */
    public function scopeIsStudent(Builder $query): void
    {
        $query->where('is_student', true)->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc');
    }

     /**
     * Scope a query to only include popular users.
     */
    public function scopeIsStaff(Builder $query): void
    {
        $query->where('is_staff', true)->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc');
    }

    public function transcriptRequests()
    {
        return $this->hasMany(TranscriptRequest::class, 'user_id', 'id');
    }
}
