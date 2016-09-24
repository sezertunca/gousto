<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Recipe;
use File;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeController extends Controller
{
    public function __construct()
    {
		if (! file_exists(storage_path('app/public/data.json')))
		{
			$data = collect($this->readCSVAndCreateRecipeObjects());
			File::put(storage_path('app/public/data.json'),$data);
		}
    }

    /**
    * Show all recipes
    * @return Response JSON
    */
    public function index()
    {
    	$recipes = json_decode(file_get_contents(storage_path('app/public/data.json')));
		return response()->json(["recipes" => $recipes], 200);
    }

    // Fetch a recipe by id
	public function show($recipeId)
	{
		$recipes = json_decode(file_get_contents(storage_path('app/public/data.json')));

		foreach($recipes as $recipe)
		{
			if ($recipe->id == $recipeId)
			{
				return response()->json(["recipe" => $recipe], 200);
			}
		}

		return response()->json(
			[
				"error" => 
						[ 
							"message" => "Couldn't find the recipe with ID: ".$recipeId 
						]
			], 404);
	}
	
	/**
    * Store a new recipe
    * @return Response JSON
    */
	public function store(Request $request)
	{
		$recipes = json_decode(file_get_contents(storage_path('app/public/data.json')));

		$last_recipe = end($recipes);
		$id = $last_recipe->id += 1;

		$recipe = new Recipe(	$id,
								date("Y-m-d H:i:s"),
								date("Y-m-d H:i:s"),
								$request['box_type'],
								$request['title'],
								$request['slug'],
								$request['short_title'],
								$request['marketing_description'],
								$request['calories_kcal'],
								$request['protein_grams'],
								$request['fat_grams'],
								$request['carbs_grams'],
								$request['bulletpoint1'],
								$request['bulletpoint2'],
								$request['bulletpoint3'],
								$request['recipe_diet_type_id'],
								$request['season'],
								$request['base'],
								$request['protein_source'],
								$request['preparation_time_minutes'],
								$request['shelf_life_days'],
								$request['equipment_needed'],
								$request['origin_country'],
								$request['recipe_cuisine'],
								$request['in_your_box'],
								$request['gousto_reference']);

		$recipes[] = $recipe;

		$data = json_encode($recipes, true);
		
		file_put_contents(storage_path('app/public/data.json'), $data);

		return response()->json(["Success" => "New recipe added."], 200);
	}

	// Update an existing recipe
	public function update(Request $request, $recipeId)
	{
		$recipes = json_decode(file_get_contents(storage_path('app/public/data.json')));
		// Validate request items
		foreach($recipes as $recipe)
		{
			if ($recipe->id == $recipeId)
			{
				$recipe->updated_at = date("Y-m-d H:i:s");
				$recipe->box_type = $request["box_type"] == null ? $recipe->box_type : $request["box_type"];
				$recipe->title = $request["title"] == null ? $recipe->title : $request["title"];
				$recipe->slug = $request["slug"] == null ? $recipe->slug : $request["slug"];
				$recipe->short_title = $request["short_title"] == null ? $recipe->short_title : $request["short_title"];
				$recipe->marketing_description = $request["marketing_description"] == null ? $recipe->marketing_description : $request["marketing_description"];
				$recipe->calories_kcal = $request["calories_kcal"] == null ? $recipe->calories_kcal : $request["calories_kcal"];
				$recipe->protein_grams = $request["protein_grams"] == null ? $recipe->protein_grams : $request["protein_grams"];
				$recipe->fat_grams = $request["fat_grams"] == null ? $recipe->fat_grams : $request["fat_grams"];
				$recipe->carbs_grams = $request["carbs_grams"] == null ? $recipe->carbs_grams : $request["carbs_grams"];
				$recipe->bulletpoint1 = $request["bulletpoint1"] == null ? $recipe->bulletpoint1 : $request["bulletpoint1"];
				$recipe->bulletpoint2 = $request["bulletpoint2"] == null ? $recipe->bulletpoint2 : $request["bulletpoint2"];
				$recipe->bulletpoint3 = $request["bulletpoint3"] == null ? $recipe->bulletpoint3 : $request["bulletpoint3"];
				$recipe->recipe_diet_type_id = $request["recipe_diet_type_id"] == null ? $recipe->recipe_diet_type_id : $request["recipe_diet_type_id"];
				$recipe->season = $request["season"] == null ? $recipe->season :  $request["season"];
				$recipe->base = $request["base"] == null ? $recipe->base : $request["base"];
				$recipe->protein_source = $request["protein_source"] == null ? $recipe->protein_source : $request["protein_source"];
				$recipe->preparation_time_minutes = $request["preparation_time_minutes"] == null ? $recipe->preparation_time_minutes :  $request["preparation_time_minutes"];
				$recipe->shelf_life_days = $request["shelf_life_days"] == null ? $recipe->shelf_life_days : $request["shelf_life_days"];
				$recipe->equipment_needed = $request["equipment_needed"] == null ? $recipe->equipment_needed : $request["equipment_needed"];
				$recipe->origin_country = $request["origin_country"] == null ? $recipe->origin_country : $request["origin_country"];
				$recipe->recipe_cuisine = $request["recipe_cuisine"] == null ? $recipe->recipe_cuisine : $request["recipe_cuisine"];
				$recipe->in_your_box = $request["in_your_box"] == null ? $recipe->in_your_box : $request["in_your_box"];
				$recipe->gousto_reference = $request["gousto_reference"] == null ? $recipe->gousto_reference : $request["gousto_reference"];
				$recipe->rate = $request["rate"] == null ? $recipe->rate : $request["rate"] ;
			}
		}

		$data = json_encode($recipes, true);
		
		file_put_contents(storage_path('app/public/data.json'), $data);

		return response()->json(["Success" => "recipe with id: ".$recipeId." updated"], 200);
	}

	// Rate an existing recipe between 1 and 5
	public function rate(Request $request, $recipeId)
	{
	}

	// Fetch all recipes for a specific cuisine (should paginate)
	public function getRecipesForCuisine($cuisine)
	{
	}

	private function readCSVAndCreateRecipeObjects()
	{
		$csv = storage_path('app/public/data.csv');    
	    
	    $rawData = array_map('str_getcsv', file($csv));

		$header = array_shift($rawData);

		$recipes = array();

		foreach ($rawData as $row) 
		{
			$recipes[] = array_combine($header, $row);
		}
		$recipeObjects = array();

		foreach($recipes as $recipe)
		{
			$recipeObjects[] = new Recipe(	$recipe['id'],
											$recipe['created_at'],
											$recipe['updated_at'],
											$recipe['box_type'],
											$recipe['title'],
											$recipe['slug'],
											$recipe['short_title'],
											$recipe['marketing_description'],
											$recipe['calories_kcal'],
											$recipe['protein_grams'],
											$recipe['fat_grams'],
											$recipe['carbs_grams'],
											$recipe['bulletpoint1'],
											$recipe['bulletpoint2'],
											$recipe['bulletpoint3'],
											$recipe['recipe_diet_type_id'],
											$recipe['season'],
											$recipe['base'],
											$recipe['protein_source'],
											$recipe['preparation_time_minutes'],
											$recipe['shelf_life_days'],
											$recipe['equipment_needed'],
											$recipe['origin_country'],
											$recipe['recipe_cuisine'],
											$recipe['in_your_box'],
											$recipe['gousto_reference']);
		}

		return $recipeObjects;
	}

		/**
     * Create a length aware custom paginator instance.
     *
     * @param  Collection  $items
     * @param  int  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginate($items, $perPage = 10)
    {
        //Get current page form url e.g. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Slice the collection to get the items to display in current page
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);

        //Create our paginator and pass it to the view
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
    }
}
