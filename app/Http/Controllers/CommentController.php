<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    use JsonResponseTrait;

    public function show(CommentRequest $request, Comment $comment): JsonResponse
    {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $this->simpleResponse(true, null, $comment->load($withArr));
    }

    public function index(CommentRequest $request): JsonResponse
    {
        $comments = Comment::latest('id');

        if ($request->bug_id ?? false) $comments->where('bug_id', '=', $request->bug_id);
        if ($request->milestone_id ?? false) $comments->where('milestone_id', '=', $request->milestone_id);
        if ($request->project_id ?? false) $comments->where('project_id', '=', $request->project_id);

        if ($request->with ?? false) $comments->with(explode(',', $request->with));

        if ($request->paginate ?? false) 
            return $this->ResponseWithPagination(true, null, $comments->paginate($request->paginate)->withQueryString());
        else 
            return $this->simpleResponse(true, null, $comments->get());
    }

    public function store(CommentRequest $request): JsonResponse
    {
        $comment = new Comment();
        $comment->fill($request->all());
        $comment->user_id = auth()->user()->id;
        $success = $comment->save();

        return $this->simpleResponse($success, 'Comment has been created.', $comment);
    }

    public function update(CommentRequest $request, Comment $comment): JsonResponse
    {
        $success = $comment->update($request->all());

        return $this->simpleResponse($success, 'Comment has been updated.', $comment);
    }

    public function destroy(CommentRequest $request, Comment $comment): JsonResponse
    {
        $comment->destroy($comment->id);

        return $this->simpleResponse(true, 'Comment has been deleted.');
    }
}
