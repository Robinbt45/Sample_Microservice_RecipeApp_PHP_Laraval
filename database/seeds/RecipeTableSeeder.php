<?php

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    Recipe::create([
		    'title' => 'American Chopsuey',
		    'description' => 'American chop suey is believed to be invented by Chinese immigrants in America in 1880\'s. A dish consisting of meat, veggies and noodles cooked quickly in sweet and tangy thickened sauce. A meal by itself! ',
		    'user_id' => 1,
	    ]);
    }
}
