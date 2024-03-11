<?php

namespace App\Http\Controllers\web\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    //

    public function index()  {
        return view('Team.Dashboard');
        
    }
}
