<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function getProjects (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return Project::latest('id')->with($withArr)->get();
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
