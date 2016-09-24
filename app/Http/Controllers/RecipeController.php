<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // Show all recipes
    public function index()
    {
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

 
}
