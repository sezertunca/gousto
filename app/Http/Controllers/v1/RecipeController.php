<?php

/**
* RecipeController.php
* Gousto API Test
*
* Created by Sezer Tunca on 24/09/2016.
* Copyright © 2016 Sezer Tunca. All rights reserved.
* Created for Gousto.
*/

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Transformers\RecipeTransformer;
use App\Recipe;
use File;
use Validator;

class RecipeController extends ApiController
{
    /**
    * @var App\Transformers\RecipeTransformer
    *
    */
    protected $recipeTransformer;

    public function __construct(RecipeTransformer $recipeTransformer)
    {
		$this->recipeTransformer = $recipeTransformer;

		if (! file_exists(storage_path('app/public/data.json')))
		{
			// Convert recipes array to collection (collect) to be able to make calls such as where('cuisine', 'asian')
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
		return $this->respond(["recipes" => $this->recipeTransformer->transformCollection($recipes)]);
    }
 
    /**
    * Fetch a recipe by id
    * @return Response JSON
    */
	public function show($recipeId)
	{
		$recipes = json_decode(file_get_contents(storage_path('app/public/data.json')));

		foreach($recipes as $recipe)
		{
			if ($recipe->id == $recipeId)
			{
				return $this->respond(["recipe" => $this->recipeTransformer->transform($recipe)]);
			}
		}
		return $this->respondNotFound('Could not find a recipe with ID: '.$recipeId);
	}
	
	/**
    * Store a new recipe
    * @return Response JSON
    */
	public function store(Request $request)
	{
		// Enable the validation rules as need 
		$rules = array(
            'box_type' => 'required | max:50',
			'title' => 'required | max:255',
			'slug' => 'required | max:255',
			// 'short_title' => 'required',
			'marketing_description' => 'required | string',
			// 'calories_kcal' => 'required',
			// 'protein_grams' => 'required',
			// 'fat_grams' => 'required',
			// 'carbs_grams' => 'required',
			// 'bulletpoint1' => 'required',
			// 'bulletpoint2' => 'required',
			// 'bulletpoint3' => 'required',
			// 'recipe_diet_type_id' => 'required',
			// 'season' => 'required',
			// 'base' => 'required',
			// 'protein_source' => 'required',
			// 'preparation_time_minutes' => 'required',
			'shelf_life_days' => 'integer',
			// 'equipment_needed' => 'required',
			'origin_country' => 'required | max:50',
			'recipe_cuisine' => 'required | max:50',
			// 'in_your_box' => 'required',
			// 'gousto_reference' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) 
        {
            return $this->respondValidationError($validator->errors()->getMessages());
        }

		$recipes = json_decode(file_get_contents(storage_path('app/public/data.json')));

		// Bad workaround for auto_increment
		$last_recipe = end($recipes);
		$id = $last_recipe->id;
		$id += 1;

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
		
		// Update the JSON file
		file_put_contents(storage_path('app/public/data.json'), $data);

		return $this->setStatusCode(201)->respond(["Success" => "New recipe added."]);
	}

	/**
    * Update an existing recipe
    * @return Response JSON
    */
	public function update(Request $request, $recipeId)
	{
		// Check if we got any field sent to update, otherwsie return immediately
		$numberOfFieldsSent = count($request->all());
		if ($numberOfFieldsSent < 1)
		{
			return $this->respondValidationError("No info sent to update");
		}

		$recipes = json_decode(file_get_contents(storage_path('app/public/data.json')));

		// Validate request items
		foreach($recipes as $recipe)
		{
			if ($recipe->id == $recipeId)
			{
				// Create a recipe with only fields provided
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
		
		// Update the JSON file
		file_put_contents(storage_path('app/public/data.json'), $data);

		return $this->respond(["Success" => "recipe with id: ".$recipeId." updated"]);
	}

	/**
    * Rate an existing recipe between 1 and 5
    * @return Response JSON
    */
	public function rate(Request $request, $recipeId)
	{
		// Validate
		// Check recipe exists
		// Check value is between 1 and 5

         $rules = array(
            'value' => 'required|integer|between:1,5',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) 
        {
            return $this->respondValidationError($validator->errors()->getMessages());
        }

		$recipes = json_decode(file_get_contents(storage_path('app/public/data.json')));

		$value = $request["value"];

		foreach($recipes as $recipe)
		{
			if ($recipe->id == $recipeId)
			{
				// Got the recipe we are looking for
				$recipe->rate = $value;

				$data = json_encode($recipes, true);
		
				// Update the JSON file
				file_put_contents(storage_path('app/public/data.json'), $data);

				return $this->respond(["info" => "recipe with id: ".$recipeId." rated with value: ".$recipe->rate]);
			}
		}
	}

	// Fetch all recipes for a specific cuisine (should paginate)
	public function getRecipesForCuisine($cuisine)
	{
		$recipes = collect(json_decode(file_get_contents(storage_path('app/public/data.json'))));

		$recipesForCuisine = $recipes->where('recipe_cuisine', $cuisine);

		$recipesForCuisine = $this->paginate($recipesForCuisine, 5);

		return $this->respond(["recipes" => $recipesForCuisine]);
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
