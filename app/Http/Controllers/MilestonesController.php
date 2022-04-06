<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Milestone;

class MilestonesController extends Controller
{
    public function getMilestones (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return Milestone::latest('id')->with($withArr)->get();
    }

    public function getMilestone (Request $request, Milestone $milestone) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $milestone->load($withArr);
    }
}
