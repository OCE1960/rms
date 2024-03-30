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
        return $this->hasMany(Comment::class, 'result_verification_request_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'result_verification_request_id', 'id');
    }

    public function submittedAttachment()
    {
        return Attachment::where('result_verification_request_id', $this->id)->where('label', 'Result Verification Request')->first();

    }

    public function resultVerificationResponseAttachment()
    {
        return Attachment::where('result_verification_request_id', $this->id)->where('label', 'Result Verification')->first();

    }

    public function studentFullname()
    {
        $item = ResultVerificationRequest::where('id', $this->id)->first();

        return $item->student_first_name." ".$item->student_middle_name."  ".$item->student_last_name;
    }

    public function enquirer()
    {
        return $this->belongsTo(User::class, 'enquirer_user_id', 'id');
    }

    public function workItem()
    {
        return $this->hasOne(WorkItem::class, 'result_verification_request_id', 'id');
    }
}
