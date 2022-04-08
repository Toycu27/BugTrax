<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Bug;

class CommentController extends Controller
{
    public function index (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build Query
        return Comment::latest('id')->with($withArr)->paginate(10)->withQueryString();
    }

    public function show (Request $request, Comment $comment) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($comment->load($withArr), 200);
    }

    public function store (Request $request) {
        $comment =  Comment::create($request->all());

        //['required', Rule::unique('posts', 'slug')]
        //['required', Rule::exists('categories', 'id')]

        return response()->json($comment, 201);
    }

    public function update (Request $request, Comment $comment) {
        $comment->update($request->all());
    
        return response()->json($comment, 200);
    }

    public function delete (Request $request, Comment $comment) {
        $comment->destroy($comment->id);

        return response()->json(null, 204);
    }
}
