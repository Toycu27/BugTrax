<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Milestone;
use App\Models\Bug;

class Project extends Model
{
    use HasFactory;

    protected $with = [];

    protected $guarded = ['id'];

    public function milestones () {
        return $this->hasMany(Milestone::Class);
    }

    public function bugs () {
        return $this->hasMany(Bug::Class);
    }

    public function scopeFilter($query, $filters) {
        return $query;
    }
}
