<?php

use Illuminate\Database\Seeder;
use App\Rectangle;

class RectanglesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rectangle::truncate();
        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 1; $i < 14; $i++) {
            Rectangle::create([
                'rectangle_id' => Str::random(10),
                'Png_id' => rand(11, 14),
                'position_x' => rand(100, 150),
                'position_y' => rand(100, 150),
                'height' => rand(50, 99),
                'width' => rand(1, 50),
                'color_code_hex' => Str::random(10),
            ]);
        }
    }
}
