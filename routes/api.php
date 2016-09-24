<?php

Route::group(['prefix' => 'v1', 'namespace' => 'v1'], function() 
{
	Route::get('/recipes', 'RecipeController@index');
	Route::get('recipes/{recipeId}', 'RecipeController@show');
	Route::post('recipes/store', 'RecipeController@store');
	Route::post('recipes/{recipeId}/update', 'RecipeController@update');
	Route::post('recipes/{recipeId}/rate', 'RecipeController@rate');
	Route::get('recipesForCuisine/{cuisine}', 'RecipeController@getRecipesForCuisine');
});