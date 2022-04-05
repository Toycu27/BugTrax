<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\Bug;

class Milestone extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function project () {
        return $this->belongsTo(Project::Class);
    }

    public function bugs () {
        return $this->hasMany(Bug::Class);
    }
}
