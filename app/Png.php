<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Png extends Model
{
    protected $table = 'png_entity';

    protected $fillable = ['request_id', 'color_code_hex', 'height', 'width', 'rectangles'];

    public function rectangles() {
        return $this->hasMany('App\Rectangle');
    }
}
