<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranscriptRequest extends Model
{
    use HasFactory;
    use HasUuids;

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function compiler()
    {
        return $this->belongsTo(User::class, 'compiled_by', 'id');
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

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function archiver()
    {
        return $this->belongsTo(User::class, 'archived_by', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'transcript_request_id', 'id');
    }

    public function originalTranscript()
    {
        return Attachment::where('transcript_request_id', $this->id)->get();
    }

    public function originalTranscriptFilePath()
    {
        return Attachment::where('transcript_request_id', $this->id)->where('is_student_copy', false)->first();
    }

    public function studentTranscriptFilePath()
    {
        return Attachment::where('transcript_request_id', $this->id)->where('is_student_copy', true)->first();
    }

    public function workItem()
    {
        return $this->hasOne(WorkItem::class, 'transcript_request_id', 'id');
    }
}
