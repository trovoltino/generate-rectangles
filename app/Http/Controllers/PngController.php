<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PngController extends Controller
{
    public function show()
    {
        $id = 0;
        if (request()->has('id')) {
            $id = request()->id;
        }
        
        return view('png')->with('id', $id);
    }
}
