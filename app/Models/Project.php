<?php

namespace App\Models;

use App\Models\Bug;
use App\Models\Milestone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    //Relations
    public function bugs()
    {
        return $this->hasMany(Bug::class);
    }

}
