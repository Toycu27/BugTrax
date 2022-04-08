<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bug;
use App\Http\Requests\BugGetRequest;

class BugController extends Controller
{
    public function index (BugGetRequest $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build and Filter Query
        $bugs = Bug::latest('id');
        if ($request->project_id ?? false) $bugs->where('project_id', '=', $request->project_id);
        if ($request->milestone_id ?? false) $bugs->where('milestone_id', '=', $request->milestone_id);
        if ($request->created_by ?? false) $bugs->where('created_by', '=', $request->created_by);
        if ($request->assigned_to ?? false) $bugs->where('assigned_to', '=', $request->assigned_to);
        if ($request->status ?? false) $bugs->where('status', '=', $request->status);
        if ($request->title ?? false) $bugs->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $bugs->where('desc', 'like', '%' . $request->desc . '%');
    
        return $bugs->with($withArr)->paginate(10)->withQueryString();
    }

    public function show (Request $request, Bug $bug) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($bug->load($withArr), 200);
    }

    public function store (Request $request) {
        $bug =  Bug::create($request->all());

        return response()->json($bug, 201);
    }

    public function update (Request $request, Bug $bug) {
        $bug->update($request->all());
    
        return response()->json($bug, 200);
    }

    public function delete (Request $request, Bug $bug) {
        $bug->destroy($bug->id);

        return response()->json(null, 204);
    }
}
