<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bug;

class BugsController extends Controller
{
    public function getBugs (Request $request) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return Bug::latest('id')->with($withArr)->get();
    }

    public function getBug (Request $request, Bug $bug) {
        $withArr = $request->with ? explode(',', $request->with) : [];

        return $bug->load($withArr);
    }
}
