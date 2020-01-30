<?php

namespace App\Helper;

/**
 * Validates if rectangles fit inside parent and if does not overlap each other
 */
class RectangleValidator
{
    public function isInsideParentContainer ($parentContainer, $rectangle)
    {
      return $parentContainer->width > $rectangle->x + $rectangle->width &&
      $parentContainer->height > $rectangle->y + $rectangle->height ? true : false;
    }

    public function hasPositiveNumbers ($rectangle)
    {
      foreach ($rectangle as $coordinate => $key) {
        if ($coordinate != 'id' && $coordinate != 'color') {
          if ((int) $key != $key || $key < 0) {

            return false;
          }
        }
      }

      return true;
    }

    public function areRectanglesOverlapping ($rectangleA, $rectangleB)
    {
      // Checks if overlaps on X axis
      $xOverlap = $rectangleA->x > $rectangleB->x + $rectangleB->width || 
      $rectangleA->x + $rectangleA->width < $rectangleB->x ? true : false;

      // Checks if overlaps on Y axis
      $yOverlap = $rectangleA->y > $rectangleB->y + $rectangleB->height || 
      $rectangleA->y + $rectangleA->height < $rectangleB->y ? true : false;

      return $xOverlap || $yOverlap;
    } 
}
