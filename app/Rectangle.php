<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rectangle extends Model
{
    protected $table = 'rectangle_entity';

    protected $fillable = ['png_id', 'rectangle_id','position_x', 'position_y', 'height', 'width', 'color_code_hex'];

    public $timestamps = false;

    public function png() {
        return $this->belongsTo('App\Png', 'png_id', 'request_id'); 
    }
}
