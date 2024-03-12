<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultVerificationRequest extends Model
{
    use HasFactory;
    use HasUuids;

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'enquirer_user_id', 'id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by', 'id');
    }

    public function recommender()
    {
        return $this->belongsTo(User::class, 'recommended_by', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function dispatcher()
    {
        return $this->belongsTo(User::class, 'dispatched_by', 'id');
    }

    public function archiver()
    {
        return $this->belongsTo(User::class, 'archived_by', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'verify_result_request_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'verify_result_request_id', 'id');
    }

    public function submittedAttachment()
    {
        return Attachment::where('verify_result_request_id', $this->id)->where('label', 'Result Verification Request')->first();

    }

    public function resultVerificationResponseAttachment()
    {
        return Attachment::where('verify_result_request_id', $this->id)->where('label', 'Result Verification')->first();

    }
}
