<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * Scope a query to only include active users.
     */
    public function scopeActiveTasks(Builder $query): void
    {
        $query->where('is_task_completed', false);
    }

    public function sendBy()
    {
        return $this->belongsTo(User::class, 'send_by', 'id');
    }

    public function sendTo()
    {
        return $this->belongsTo(User::class, 'send_to', 'id');
    }

    public function workItem()
    {
        return $this->belongsTo(WorkItem::class, 'work_item_id', 'id');
    }
}
