<?php

use Illuminate\Database\Seeder;
use App\Png;

class PngsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Png::truncate();
        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 1; $i < 4; $i++) {
            Png::create([
                'request_id' => 10+$i,
                'color_code_hex' => Str::random(10),
                'height' => rand(50, 99),
                'width' => rand(1, 50)
            ]);
        }
    }
}
