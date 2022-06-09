<?php

namespace App\Http\Controllers;

use App\Http\Requests\BugRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Models\Bug;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BugController extends Controller
{
    use JsonResponseTrait;
    
    public function show(BugRequest $request, Bug $bug): JsonResponse
    {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $this->simpleResponse(true, null, $bug->load($withArr));
    }

    public function index(BugRequest $request): JsonResponse
    {
        $bugs = Bug::class;

        $orderCount = 0;
        if ($request->sort ?? false) {
            foreach($request->sort AS $field => $order) {
                if (in_array($field, Bug::$sortable)) {
                    if ($orderCount === 0) $bugs = Bug::orderBy($field, $order === 'ASC' ? 'ASC' : 'DESC');
                    else $bugs->orderBy($field, $order === 'ASC' ? 'ASC' : 'DESC');
                    $orderCount++;
                }
            }
        }
        if ($orderCount === 0) $bugs = Bug::latest('id');

        if ($request->project_id ?? false) $bugs->where('project_id', '=', $request->project_id);
        if ($request->milestone_id ?? false) $bugs->where('milestone_id', '=', $request->milestone_id);
        if ($request->created_by ?? false) $bugs->where('created_by', '=', $request->created_by);
        if ($request->assigned_to ?? false) $bugs->where('assigned_to', '=', $request->assigned_to);
        if ($request->status_id ?? false) $bugs->where('status_id', '=', $request->status_id);
        if ($request->title ?? false) $bugs->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $bugs->where('desc', 'like', '%' . $request->desc . '%');
        
        if ($request->with ?? false) $bugs->with(explode(',', $request->with));

        if ($request->paginate ?? false) 
            return $this->ResponseWithPagination(true, null, $bugs->paginate($request->paginate)->withQueryString());
        else 
            return $this->simpleResponse(true, null, $bugs->get());
    }

    public function store(BugRequest $request): JsonResponse
    {
        $bug = new Bug();
        $bug->fill($request->all());
        $bug->slug = Str::slug($bug->title);
        $bug->created_by = auth()->user()->id;
        $success = $bug->save();

        return $this->simpleResponse($success, 'Bug has been created.', $bug);
    }

    public function update(BugRequest $request, Bug $bug): JsonResponse
    {
        $bug->slug = Str::slug($request->title);
        $bug->modified_by = auth()->user()->id;
        $success = $bug->update($request->all());

        return $this->simpleResponse($success, 'Bug has been updated.', $bug);
    }

    public function destroy(BugRequest $request, Bug $bug): JsonResponse
    {
        $bug->destroy($bug->id);

        return $this->simpleResponse(true, 'Bug has been deleted.');
    }
}
