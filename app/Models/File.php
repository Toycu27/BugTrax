<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bug;

class File extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bug () {
        return $this->belongsTo(Bug::Class);
    }
}
