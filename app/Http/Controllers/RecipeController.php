<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Recipe;
use File;

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

    // Show all recipes
    public function index()
    {
    	$recipes = json_decode(file_get_contents(storage_path('app/public/data.json')));
		return response()->json(["recipes" => $recipes], 200);
    }

    // Fetch a recipe by id
	public function show($recipeId)
	{
	}

	// Rate an existing recipe between 1 and 5
	public function rate(Request $request, $recipeId)
	{
	}

	// Update an existing recipe
	public function update(Request $request, $recipeId)
	{
	}

	// Store a new recipe
	public function store(Request $request)
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

 
}
