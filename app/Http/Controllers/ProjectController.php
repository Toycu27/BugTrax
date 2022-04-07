<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function getProjects (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Validate Request
        

        //Build Query
        $projects = Project::latest('id');

        //Filter Query
        $filters = $request->filter ? json_decode($request->filter) : null;
        if ($filters !== null) {
            if (isset($filters->slug)) $projects->where('slug', '=', $filters->slug);
            if (isset($filters->title)) $projects->where('title', 'like', '%' . $filters->title . '%');
            if (isset($filters->desc)) $projects->where('desc', 'like', '%' . $filters->desc . '%');
        }
        
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
