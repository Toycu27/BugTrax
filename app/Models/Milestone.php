<?php

namespace App\Models;

use App\Models\Bug;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    //Traits
    use HasFactory;
    use SoftDeletes;

    public static $sortable = [
        'id',
        'end_date',
        'start_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = [];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at', 
        'deleted_at',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'start_date'  => 'datetime:Y-m-d\TH:i',
        'end_date'  => 'datetime:Y-m-d\TH:i',
        'created_at'  => 'datetime:Y-m-d\TH:i',
        'updated_at' => 'datetime:Y-m-d\TH:i',
        'deleted_at' => 'datetime:Y-m-d\TH:i',
    ];

    //Relations
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function bugs()
    {
        return $this->hasMany(Bug::class);
    }
}
