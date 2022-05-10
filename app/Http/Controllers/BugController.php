<?php

namespace App\Http\Controllers;

use App\Http\Requests\BugRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Models\Bug;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BugController extends Controller
{

    public function show(BugRequest $request, Bug $bug): JsonResponse
    {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($bug->load($withArr), 200);
    }

    public function index(BugRequest $request): JsonResponse
    {
        $bugs = Bug::latest('id');

        if ($request->project_id ?? false) $bugs->where('project_id', '=', $request->project_id);
        if ($request->milestone_id ?? false) $bugs->where('milestone_id', '=', $request->milestone_id);
        if ($request->created_by ?? false) $bugs->where('created_by', '=', $request->created_by);
        if ($request->assigned_to ?? false) $bugs->where('assigned_to', '=', $request->assigned_to);
        if ($request->status ?? false) $bugs->where('status', '=', $request->status);
        if ($request->title ?? false) $bugs->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $bugs->where('desc', 'like', '%' . $request->desc . '%');
        
        if ($request->with ?? false) $bugs->with(explode(',', $request->with));

        if ($request->paginate ?? false) return response()->json(
            $bugs->paginate($request->paginate)->withQueryString(),
            200
        );
        else return response()->json([
            'data' => $bugs->get()
        ], 200);
    }

    public function store(BugRequest $request): JsonResponse
    {
        $bug = new Bug();
        $bug->fill($request->all());
        $bug->slug = Str::slug($bug->title);
        $bug->created_by = auth()->user()->id;
        $bug->save();

        return response()->json([
            'success' => true,
            'data' => $bug,
            'message' => 'Bug has been created.',
        ], 201);
    }

    public function update(BugRequest $request, Bug $bug): JsonResponse
    {
        $bug->slug = Str::slug($request->title);
        $bug->modified_by = auth()->user()->id;
        $bug->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $bug,
            'message' => 'Bug has been updated.',
        ], 200);
    }

    public function destroy(BugRequest $request, Bug $bug): JsonResponse
    {
        $bug->destroy($bug->id);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Bug has been deleted.',
        ], 204);
    }
}
