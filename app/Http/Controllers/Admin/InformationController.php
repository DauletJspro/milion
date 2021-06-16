<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Home;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index()
    {
        $results = (new \App\Models\Information())->get_items();
        return view('information.index', compact('results'));
    }


    public function ajax(Request $request)
    {
        $week_number = $request->week_number ?? 0;
        $method = $request->type;
        switch ($method) {
            case 'registered_count':
                $result = Information::getRegisteredCount($week_number, $method);
                break;
        }

        return $result;
    }
}
