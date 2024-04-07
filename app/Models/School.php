<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'short_name',
        'address_street',
        'address_mailbox',
        'address_mailbox',
        'address_town',
        'state',
        'geo_zone',
        'type',
        'official_phone',
        'official_email',
        'official_website',
    ];

    public function semesters()
    {
        return $this->hasMany(Semester::class, 'school_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'school_id', 'id');
    }

    public function transcriptRequests()
    {
        return $this->hasMany(TranscriptRequest::class, 'school_id', 'id');
    }

    public function resultVerificationRequets()
    {
        return $this->hasMany(ResultVerificationRequest::class, 'school_id', 'id');
    }
}
