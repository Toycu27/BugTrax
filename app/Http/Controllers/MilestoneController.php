<?php

namespace App\Http\Controllers;

use App\Http\Requests\MilestoneRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Milestone;
use Illuminate\Support\Str;

class MilestoneController extends Controller
{
    public function show (MilestoneRequest $request, Milestone $milestone): JsonResponse {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($milestone->load($withArr), 200);
    }

    public function index (MilestoneRequest $request): JsonResponse {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build and Filter Query
        $milestones = Milestone::latest('id');
        if ($request->title ?? false) $milestones->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $milestones->where('desc', 'like', '%' . $request->desc . '%');

        return response()->json(
            $milestones->with($withArr)->paginate(10)->withQueryString(),
            200
        );
    }

    public function store (MilestoneRequest $request): JsonResponse {
        $milestone = new Milestone();
        $milestone->fill($request->all());
        $milestone->slug = Str::slug($milestone->title);
        $milestone->save();

        return response()->json([
            'success' => true,
            'data' => $milestone,
            'message' => 'Milestone has been created.',
        ], 201);
    }

    public function update (MilestoneRequest $request, Milestone $milestone): JsonResponse {
        $milestone->slug = Str::slug($request->title);
        $milestone->update($request->all());
    
        return response()->json([
            'success' => true,
            'data' => $milestone,
            'message' => 'Milestone has been updated.',
        ], 200);
    }

    public function delete (MilestoneRequest $request, Milestone $milestone): JsonResponse {
        $milestone->destroy($milestone->id);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Milestone has been deleted.',
        ], 204);
    }
}
