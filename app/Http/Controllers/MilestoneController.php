<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Milestone;

class MilestoneController extends Controller
{
    public function getMilestones (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        //Build Query
        $milestones = Milestone::latest('id');

        //Filter Query
        $filters = $request->filter ? json_decode($request->filter) : null;
        if ($filters !== null) {
            if (isset($filters->slug)) $milestones->where('slug', '=', $filters->slug);
            if (isset($filters->title)) $milestones->where('title', 'like', '%' . $filters->title . '%');
            if (isset($filters->desc)) $milestones->where('desc', 'like', '%' . $filters->desc . '%');
        }

        return $milestones->with($withArr)->paginate(10)->withQueryString();
    }

    public function getMilestone (Request $request, Milestone $milestone) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $milestone->load($withArr);
    }
}
