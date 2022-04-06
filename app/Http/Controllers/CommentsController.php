<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function getComments (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return Comment::latest('id')->with($withArr)->get();
    }

    public function getComment (Request $request, Comment $comment) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $comment->load($withArr);
    }
}
