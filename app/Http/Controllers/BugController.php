<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bug;

class BugController extends Controller
{
    public function getBugs (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build Query
        $bugs = Bug::latest('id');

        //Filter Query
        $filters = $request->filter ? json_decode($request->filter) : null;
        if ($filters !== null) {
            if (isset($filters->project_id)) $bugs->where('project_id', '=', $filters->project_id);
            if (isset($filters->milestone_id)) $bugs->where('milestone_id', '=', $filters->milestone_id);
            if (isset($filters->created_by)) $bugs->where('created_by', '=', $filters->created_by);
            if (isset($filters->assigned_to)) $bugs->where('assigned_to', '=', $filters->assigned_to);
            if (isset($filters->status)) $bugs->where('status', '=', $filters->status);
            if (isset($filters->slug)) $bugs->where('slug', '=', $filters->slug);
            if (isset($filters->title)) $bugs->where('title', 'like', '%' . $filters->title . '%');
            if (isset($filters->desc)) $bugs->where('desc', 'like', '%' . $filters->desc . '%');
        }

        return $bugs->with($withArr)->paginate(10)->withQueryString();
    }

    public function getBug (Request $request, Bug $bug) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $bug->load($withArr);
    }
}
