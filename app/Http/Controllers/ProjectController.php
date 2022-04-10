<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function show (ProjectRequest $request, Project $project): JsonResponse {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($project->load($withArr), 200);
    }

    public function index (ProjectRequest $request): JsonResponse {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build and Filter Query
        $projects = Project::latest('id');
        if ($request->title ?? false) $projects->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $projects->where('desc', 'like', '%' . $request->desc . '%');
        
        return response()->json(
            $projects->with($withArr)->paginate(10)->withQueryString(),
            200
        );
    }

    public function store (ProjectRequest $request): JsonResponse {
        $project = new Project();
        $project->fill($request->all());
        $project->slug = Str::slug($project->title);
        $project->save();

        return response()->json($project, 201);
    }

    public function update (ProjectRequest $request, Project $project): JsonResponse {
        $project->slug = Str::slug($request->title);
        $project->update($request->all());
    
        return response()->json($project, 200);
    }

    public function delete (ProjectRequest $request, Project $project): JsonResponse {
        $project->destroy($project->id);

        return response()->json(null, 204);
    }
}
