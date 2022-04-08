<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\ProjectGetRequest;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    public function index (ProjectGetRequest $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build and Filter Query
        $projects = Project::latest('id');
        if ($request->title ?? false) $projects->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $projects->where('desc', 'like', '%' . $request->desc . '%');
        
        return $projects
            ->with($withArr)
            ->paginate(10)
            ->withQueryString();
    }

    public function show (Request $request, Project $project) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($project->load($withArr), 200);
    }

    public function store (Request $request) {
        $project = Project::create($request->all());

        return response()->json($project, 201);
    }

    public function update (Request $request, Project $project) {
        $project->update($request->all());
    
        return response()->json($project, 200);
    }

    public function delete (Request $request, Project $project) {
        $project->destroy($project->id);

        return response()->json(null, 204);
    }
}
