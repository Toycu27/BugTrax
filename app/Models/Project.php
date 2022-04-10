<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Milestone;
use App\Models\Bug;

class Project extends Model
{
    //Traits
    use HasFactory;
    use SoftDeletes;

    protected $with = [];
    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function milestones () {
        return $this->hasMany(Milestone::class);
    }

    //Relations
    public function bugs () {
        return $this->hasMany(Bug::class);
    }

}
