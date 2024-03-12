<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkItem extends Model
{
    use HasFactory;
    use HasUuids;

    public function transcriptRequest()
    {
        return $this->belongsTo(TranscriptRequest::class, 'transcript_request_id', 'id');
    }

    public function resultVerificationRequest()
    {
        return $this->belongsTo(ResultVerificationRequest::class, 'result_verification_request_id', 'id');
    }
}
