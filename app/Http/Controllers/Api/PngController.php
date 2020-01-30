<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Png;
use App\Rectangle;
use App\Helper\RectangleValidator;
use Illuminate\Routing\UrlGenerator;

class PngController extends Controller
{
    const BAD_REQUEST = 400;
    const OK_REQUEST = 200;
    const ASSETS_DIR = 'assets/';

    private $rectangleValidator;
    protected $url;
    protected $request_id;

    public function __construct (RectangleValidator $rectangleValidator, UrlGenerator $url) {
        $this->rectangleValidator = $rectangleValidator;
        $this->url = $url;
    }

    public function add(Request $request)
    {
        $pngAttributes = [];
        $coords = [];
        $data = json_decode($request->getContent());
        $this->request_id = uniqid(true);
        $this->createPngEntity($data);
        // Initiate parent container
        $image = imagecreatetruecolor($data->width, $data->height);
        $color = $this->hexColorAllocate($image, $data->color_code_hex);
        imagefill($image, 0, 0, $color);

        foreach ($data->rectangles as $rectangle) {

                if ($this->rectangleValidator->hasPositiveNumbers($rectangle)) {

                    // Checks if rectangle are in bounds of parent container
                    if($this->rectangleValidator->isInsideParentContainer($data, $rectangle)) {

                        foreach($data->rectangles as $innerRectangle) {
                            // Checks rectangles if they overlap each other
                            if ($rectangle->id !== $innerRectangle->id) {
                                if (!$this->rectangleValidator->areRectanglesOverlapping($rectangle, $innerRectangle)) {
                                    $response['success'] = false;
                                    $response['errors'] = 'rectangle with id = '.$innerRectangle->id . ' overlap with id = ' . $rectangle->id;
                                    return response()->json($response, self::BAD_REQUEST);
                                }
                            }
                        }
                        
                        $this->createRectangleEntity($rectangle);
                        $color = $this->hexColorAllocate($image, $rectangle->color);
                        imagefilledrectangle($image, $rectangle->x, $rectangle->y, ($rectangle->x + $rectangle->width), ($rectangle->y + $rectangle->height), $color);
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

        // header('Content-Disposition: Attachment;filename=image.png');
        //header('Content-type: image/png');
        $pathToImage = self::ASSETS_DIR . $this->request_id . '.png';
        imagepng($image, $pathToImage);
        imagedestroy($image);
        $pngViewUrl = $this->url->to('/').'/'.'png?id=';

        $response['success'] = true;
        $response['url'] = $pngViewUrl.$this->request_id;

        return response()->json($response, self::OK_REQUEST);
    }

    /**
     * @param  image $image
     * @param  string $hexCode
     * @return mixed
     */
    protected function hexColorAllocate($image, $hexCode)
    {
        $hexCode = ltrim($hexCode,'#');
        $a = hexdec(substr($hexCode,0,2));
        $b = hexdec(substr($hexCode,2,2));
        $c = hexdec(substr($hexCode,4,2));
        return imagecolorallocate($image, $a, $b, $c); 
    }

    /**
     * @param  $rectangle
     */
    protected function createRectangleEntity ($rectangle)
    {
        $newRectangle = Rectangle::create([
            'rectangle_id' => $rectangle->id,
            'png_id' => $this->request_id,
            'position_x' => $rectangle->x,
            'position_y' => $rectangle->y,
            'width' => $rectangle->width,
            'height' => $rectangle->height,
            'color_code_hex' => $rectangle->color
        ]);
    }

     /**
     * @param  $data
     */
    protected function createPngEntity ($data)
    {
        $newPng = Png::create([
            'request_id' => $this->request_id,
            'width' => $data->width,
            'height' => $data->height,
            'color_code_hex' => $data->color_code_hex
        ]);
    }
}
