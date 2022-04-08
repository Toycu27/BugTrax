<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\File;
use App\Models\Comment;

class Bug extends Model
{
    use HasFactory;

    protected $with = [];

    protected $guarded = ['id', 'created_by', 'modified_by'];


    public function project () {
        return $this->belongsTo(Project::class);
    }

    public function milestone () {
        return $this->belongsTo(Milestone::class);
    }

    public function createdBy () {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifiedBy () {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function assignedTo () {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function files () {
        return $this->hasMany(File::class);
    }

    public function comments () {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter($query, $filters) {
        return $query;
    }
}
