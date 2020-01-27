<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Png;
use App\Rectangle;
use App\Helper\RectangleValidator;

class PngController extends Controller
{
    private $rectangleValidator;
    const BAD_REQUEST = 400;
    const OK_REQUEST = 200;

    public function __construct (RectangleValidator $rectangleValidator) {
        $this->rectangleValidator = $rectangleValidator;
    }

    public function add(Request $request)
    {
        $pngAttributes = [];
        $coords = [];
        $data = json_decode($request->getContent());
        $response;

        if (is_array($data->rectangles)) {
            $parentContainer['width'] = $data->width;
            $parentContainer['height'] = $data->height;
            foreach ($data->rectangles as $rectangle) {

                // Checks if all provided numbers are valid integers
                if ($this->rectangleValidator->hasPositiveNumbers($rectangle)) {

                    // Checks if rectangle are in bounds of parent container
                    if($this->rectangleValidator->isInsideParentContainer($parentContainer, $rectangle))  {
                        foreach($data->rectangles as $innerRectangle) {

                            // Checks rectangles if they overlap each other
                            if ($rectangle->id !== $innerRectangle->id) {
                                if (!$this->rectangleValidator->areRectanglesOverlapping($rectangle, $innerRectangle)) {
                                    $response['success'] = false;
                                    $response['errors'] = 'rectangles_overlap with id = '.$innerRectangle->id;
                                    return response()->json($response, self::BAD_REQUEST);
                                }
                            }
                        }
                    } else {
                        $response['success'] = false;
                        $response['errors'] = 'rectangles_out_of_bounds with id = '.$rectangle->id;
                        return response()->json($response, self::BAD_REQUEST);
                    }
                } else {
                    $response['success'] = false;
                    $response['errors'] = 'one of parameters is invalid';
                    return response()->json($response , self::BAD_REQUEST);
                };
            }
            return response()->json('isPositive and is inside and does not overlap', self::OK_REQUEST);
            
            $this->validateRectangle($data->rectangles);
        } else {
            return response()->json('Malformated_json', self::BAD_REQUEST);
        }

        $newPng = Png::create([
            'request_id' => $data->request_id,
            'width' => $data->width,
            'height' => $data->height,
            'color_code_hex' => $data->color_code_hex
        ]);
        
        // $this->validateRectangle($data->rectangles);
        
        return response()->json('Rectangle created', self::OK_REQUEST);
        
        return $pngAttributes + "and rectangles array =" + $rectangles;
    }
}
