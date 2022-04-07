<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Milestone;
use App\Http\Requests\MilestoneGetRequest;

class MilestoneController extends Controller
{
    public function getMilestones (MilestoneGetRequest $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build and Filter Query
        $milestones = Milestone::latest('id');
        if ($request->title ?? false) $milestones->where('title', 'like', '%' . $request->title . '%');
        if ($request->desc ?? false) $milestones->where('desc', 'like', '%' . $request->desc . '%');

        return $milestones->with($withArr)->paginate(10)->withQueryString();
    }

    public function getMilestone (Request $request, Milestone $milestone) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $milestone->load($withArr);
    }
}
