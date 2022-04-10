<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bug;

class Comment extends Model
{
    //Traits
    use HasFactory;

    protected $with = [];
    protected $guarded = ['id', 'user_id'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    //Relations
    public function user () {
        return $this->belongsTo(User::class);
    }

    public function bug () {
        return $this->belongsTo(Bug::class);
    }
}
