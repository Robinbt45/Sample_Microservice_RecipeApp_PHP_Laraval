<?php

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    Ingredient::create([
		    'recipe_id' => 1,
		    'name' => 'capsicum',
		    'quantity' => '1 medium / 50g'
	    ]);
	    Ingredient::create([
		    'recipe_id' => 1,
		    'name' => 'cabbage',
		    'quantity' => 'cut into cubes ¼ cup / 50g'
	    ]);
	    Ingredient::create([
		    'recipe_id' => 1,
		    'name' => 'noodles, boiled & fried',
		    'quantity' => '50g'
	    ]);
	    Ingredient::create([
		    'recipe_id' => 1,
		    'name' => 'oil',
		    'quantity' => '1 tbsp'
	    ]);
	    Ingredient::create([
		    'recipe_id' => 1,
		    'name' => 'spring onion, chopped (for garnishing)',
		    'quantity' => '2 unit'
	    ]);
    }
}
