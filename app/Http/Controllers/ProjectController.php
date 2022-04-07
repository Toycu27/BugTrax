<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\ProjectGetRequest;

class ProjectController extends Controller
{
    public function getProjects (ProjectGetRequest $request) {
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

    public function getProject (Request $request, Project $project) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $project->load($withArr);
    }

    public function postProject (Request $request) {

    }

    public function patchProject (Request $request, Project $project) {
        
    }

    public function deleteProject (Request $request, Project $project) {
        
    }
}
