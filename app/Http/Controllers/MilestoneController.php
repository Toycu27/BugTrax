<?php

namespace App\Http\Controllers;

use App\Http\Requests\MilestoneRequest;
use App\Models\Milestone;
use Illuminate\Support\Str;

class MilestoneController extends Controller
{
    public function show (MilestoneRequest $request, Milestone $milestone) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return response()->json($milestone->load($withArr), 200);
    }

    public function index (MilestoneRequest $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build and Filter Query
        $milestones = Milestone::latest('id');
        if ($request->title ?? false) $milestones->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $milestones->where('desc', 'like', '%' . $request->desc . '%');

        return $milestones->with($withArr)->paginate(10)->withQueryString();
    }

    public function store (MilestoneRequest $request) {
        $milestone = new Milestone();
        $milestone->fill($request->all());
        $milestone->slug = Str::slug($milestone->title);
        $milestone->save();

        return response()->json($milestone, 201);
    }

    public function update (MilestoneRequest $request, Milestone $milestone) {
        $milestone->slug = Str::slug($request->title);
        $milestone->update($request->all());
    
        return response()->json($milestone, 200);
    }

    public function delete (MilestoneRequest $request, Milestone $milestone) {
        $milestone->destroy($milestone->id);

        return response()->json(null, 204);
    }
}
