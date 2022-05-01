<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function show(CommentRequest $request, Comment $comment): JsonResponse
    {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($comment->load($withArr), 200);
    }

    public function index(CommentRequest $request): JsonResponse
    {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json(
            Comment::latest('id')->with($withArr)->paginate(10)->withQueryString(),
            200
        );
    }

    public function store(CommentRequest $request): JsonResponse
    {
        $comment = new Comment();
        $comment->fill($request->all());
        $comment->user_id = 1;
        $comment->save();

        return response()->json([
            'success' => true,
            'data' => $comment,
            'message' => 'Comment has been created.',
        ], 201);
    }

    public function update(CommentRequest $request, Comment $comment): JsonResponse
    {
        $comment->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $comment,
            'message' => 'Comment has been updated.',
        ], 200);
    }

    public function delete(CommentRequest $request, Comment $comment): JsonResponse
    {
        $comment->destroy($comment->id);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Comment has been deleted.',
        ], 204);
    }
}
