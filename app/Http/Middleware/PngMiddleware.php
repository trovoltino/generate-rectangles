<?php

namespace App\Http\Middleware;

use Closure;

class PngMiddleware
{
    const MAX_PNG_HEIGHT = 1080;
    const MAX_PNG_WIDTH = 1920;
    const MIN_PNG_HEIGHT = 480;
    const MIN_PNG_WIDTH = 640;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $bodyContent = json_decode($request->getContent());

            // Checks if all parameters provided in request
            if ( property_exists($bodyContent, 'height') && 
                property_exists($bodyContent, 'width') &&
                property_exists($bodyContent, 'color_code_hex') &&
                property_exists($bodyContent, 'rectangles') && 
                is_array($bodyContent->rectangles)
            ) {
                $isPngDimensionsValid = $this->isPngDimensionsValid($bodyContent->width, $bodyContent->height);
                $isColorValidHex = $this->isColorHex($bodyContent->color_code_hex);
        
                if($isPngDimensionsValid) {
                    return $isColorValidHex ? $next($request) : response()->json('color_code is not valid Hex code', 400);
                } else {
                    return response()->json('Width or height is out of bounds', 400);
                }
            } else {
                return response()->json('invalid json', 400);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * @param  Integer  $width
     * @param  Integer  $height
     * @return boolean
     */
    private function isPngDimensionsValid($width, $height)
    {
        if ($height < self::MAX_PNG_HEIGHT && $width < self::MAX_PNG_WIDTH &&
            $height > self::MIN_PNG_HEIGHT && $width > self::MIN_PNG_WIDTH) {
            return true;
        } else {
            return false;
        }
    }

     /**
     * @param  string  $color_code
     * @return boolean
     */
    private function isColorHex($color_code)
    {
        if( preg_match('/^#[a-f0-9]{6}$/i', $color_code) ) {
           return true;
        } else {
            return false;
        }
    }
}
