<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnalyzeController extends Controller
{
    function user(){
        return view('admin.analyze');
    }
}
