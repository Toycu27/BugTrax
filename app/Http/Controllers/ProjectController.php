<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    use JsonResponseTrait;

    public function show(ProjectRequest $request, Project $project): JsonResponse
    {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $this->simpleResponse(true, null, $project->load($withArr));
    }

    public function index(ProjectRequest $request): JsonResponse
    {
        $projects = Project::latest('id');
        
        if ($request->title ?? false) $projects->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $projects->where('desc', 'like', '%' . $request->desc . '%');
        
        if ($request->with ?? false) $projects->with(explode(',', $request->with));

        if ($request->paginate ?? false) 
            return $this->ResponseWithPagination(true, null, $projects->paginate($request->paginate)->withQueryString());
        else 
            return $this->simpleResponse(true, null, $projects->get());
    }

    public function store(ProjectRequest $request): JsonResponse
    {
        $project = new Project();
        $project->fill($request->all());
        $project->slug = Str::slug($project->title);
        $success = $project->save();

        return $this->simpleResponse($success, 'Project has been created.', $project);
    }

    public function update(ProjectRequest $request, Project $project): JsonResponse
    {
        $project->slug = Str::slug($request->title);
        $success = $project->update($request->all());

        return $this->simpleResponse($success, 'Project has been updated.', $project);
    }

    public function destroy(ProjectRequest $request, Project $project): JsonResponse
    {
        $project->destroy($project->id);

        return $this->simpleResponse(true, 'Project has been deleted.');
    }
}
