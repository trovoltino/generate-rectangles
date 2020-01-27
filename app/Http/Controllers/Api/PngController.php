<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Png;
use App\Rectangle;

class PngController extends Controller
{
    public function add(Request $request)
    {
        
        $pngAttributes = [];
        
        $data = json_decode($request->getContent());
        // return response()->json($data['width'], 200);
        $newPng = Png::create([
            'request_id' => $data->request_id,
            'width' => $data->width,
            'height' => $data->height,
            'color_code_hex' => $data->color_code_hex
        ]);

        if (is_array($data->rectangles)) {
            return response()->json($data->rectangles, 200);
            $this->validateRectangle($data->rectangles);
        }

        // $this->validateRectangle($data->rectangles);
        
        return response()->json('Rectangle created', 200);

        
        return $pngAttributes + "and rectangles array =" + $rectangles;
    }

    private function validateRectangle () {

    }

    private function addRectangle($rectangle) {

    }
}
