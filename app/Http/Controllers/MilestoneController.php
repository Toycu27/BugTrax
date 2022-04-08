<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Milestone;
use App\Http\Requests\MilestoneGetRequest;

class MilestoneController extends Controller
{
    public function index (MilestoneGetRequest $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build and Filter Query
        $milestones = Milestone::latest('id');
        if ($request->title ?? false) $milestones->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $milestones->where('desc', 'like', '%' . $request->desc . '%');

        return $milestones->with($withArr)->paginate(10)->withQueryString();
    }

    public function show (Request $request, Milestone $milestone) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($milestone->load($withArr), 200);
    }

    public function store (Request $request) {
        $milestone = Milestone::create($request->all());

        return response()->json($milestone, 201);
    }

    public function update (Request $request, Milestone $milestone) {
        $milestone->update($request->all());
    
        return response()->json($milestone, 200);
    }

    public function delete (Request $request, Milestone $milestone) {
        $milestone->destroy($milestone->id);

        return response()->json(null, 204);
    }
}
