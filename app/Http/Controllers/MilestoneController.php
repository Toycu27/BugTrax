<?php

namespace App\Http\Controllers;

use App\Http\Requests\MilestoneRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Models\Milestone;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class MilestoneController extends Controller
{
    use JsonResponseTrait;

    public function show(MilestoneRequest $request, Milestone $milestone): JsonResponse
    {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $this->simpleResponse(true, null, $milestone->load($withArr));
    }

    public function index(MilestoneRequest $request): JsonResponse
    {
        $milestones = Milestone::class;

        $orderCount = 0;
        if ($request->sort ?? false) {
            foreach($request->sort AS $field => $order) {
                if (in_array($field, Milestone::$sortable)) {
                    if ($orderCount === 0) $milestones = Milestone::orderBy($field, $order === 'ASC' ? 'ASC' : 'DESC');
                    else $milestones->orderBy($field, $order === 'ASC' ? 'ASC' : 'DESC');
                    $orderCount++;
                }
            }
        }
        if ($orderCount === 0) $milestones = Milestone::latest('id');

        if ($request->project_id ?? false) $milestones->where('project_id', '=', $request->project_id);
        if ($request->title ?? false) $milestones->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $milestones->where('desc', 'like', '%' . $request->desc . '%');
        
        if ($request->with ?? false) $milestones->with(explode(',', $request->with));

        if ($request->paginate ?? false) 
            return $this->ResponseWithPagination(true, null, $milestones->paginate($request->paginate)->withQueryString());
        else 
            return $this->simpleResponse(true, null, $milestones->get());
    }

    public function store(MilestoneRequest $request): JsonResponse
    {
        $milestone = new Milestone();
        $milestone->fill($request->all());
        $milestone->slug = Str::slug($milestone->title);
        $success = $milestone->save();

        return $this->simpleResponse($success, 'Milestone has been created.', $milestone);
    }

    public function update(MilestoneRequest $request, Milestone $milestone): JsonResponse
    {
        $milestone->slug = Str::slug($request->title);
        $success = $milestone->update($request->all());

        return $this->simpleResponse($success, 'Milestone has been updated.', $milestone);
    }

    public function destroy(MilestoneRequest $request, Milestone $milestone): JsonResponse
    {
        $milestone->destroy($milestone->id);

        return $this->simpleResponse(true, 'Milestone has been deleted.');
    }
}
