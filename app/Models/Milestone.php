<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\Bug;

class Milestone extends Model
{
    use HasFactory;

    protected $with = [];

    protected $guarded = ['id'];

    public function project () {
        return $this->belongsTo(Project::class);
    }

    public function bugs () {
        return $this->hasMany(Bug::class);
    }

    public function scopeFilter($query, $filters) {
        return $query;
    }
}
