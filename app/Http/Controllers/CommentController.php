<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function getComments (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build Query
        return Comment::latest('id')->with($withArr)->paginate(10)->withQueryString();
    }

    public function getComment (Request $request, Comment $comment) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $comment->load($withArr);
    }
}
