<?php

use App\Models\Step;
use Illuminate\Database\Seeder;

class StepTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    Step::create([
	    	'recipe_id'=> 1,
	    	'step_order'=> 1,
		    'description' => 'Heat oil in a pan, add cut vegetables and saute for a minute.'
	    ]);
	    Step::create([
	    	'recipe_id'=> 1,
	    	'step_order'=> 2,
		    'description' => 'Add water and American Chop Suey Ready Mix. Stir well and cook for 5-6 minutes or till the sauce thickens.'
	    ]);
	    Step::create([
	    	'recipe_id'=> 1,
	    	'step_order'=> 3,
		    'description' => 'Place the fried noodles in a serving bowl and pour the sauce over it.'
	    ]);
	    Step::create([
	    	'recipe_id'=> 1,
	    	'step_order'=> 4,
		    'description' => 'Garnish with spring onion and serve hot.'
	    ]);
    }
}
