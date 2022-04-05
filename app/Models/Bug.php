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

    protected $guarded = ['id'];


    public function project () {
        return $this->belongsTo(Project::Class);
    }

    public function milestone () {
        return $this->belongsTo(Milestone::Class);
    }

    public function createdBy () {
        return $this->belongsTo(User::Class);
    }

    public function modifiedBy () {
        return $this->belongsTo(User::Class);
    }

    public function assignedTo () {
        return $this->belongsTo(User::Class);
    }

    public function files () {
        return $this->hasMany(File::Class);
    }

    public function comments () {
        return $this->hasMany(Comment::Class);
    }
}
