<?php

namespace App\Http\Middleware;

use Closure;

class PngMiddleware
{

    const MAX_PNG_HEIGHT = 1720;
    const MAX_PNG_WIDTH = 1020;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $bodyContent = json_decode($request->getContent());
        if (property_exists($bodyContent, 'request_id') &&
            property_exists($bodyContent, 'height') && 
            property_exists($bodyContent, 'width') &&
            property_exists($bodyContent, 'color_code_hex')
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
    }

    private function isPngDimensionsValid($width, $height)
    {
        if ($height < self::MAX_PNG_HEIGHT && $width < self::MAX_PNG_WIDTH) {
            return true;
        } else {
            return false;
        }
    }

    private function isColorHex($color_code)
    {
        
        if( preg_match('/^#[a-f0-9]{6}$/i', $color_code) ) {
          
           return true;
        } else {
            return false;
        }
    }
}
