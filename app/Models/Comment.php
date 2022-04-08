<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bug;

class Comment extends Model
{
    use HasFactory;

    protected $with = [];

    protected $guarded = ['id', 'user_id'];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function bug () {
        return $this->belongsTo(Bug::class);
    }

    public function scopeFilter($query, $filters) {
        return $query;
    }
}
