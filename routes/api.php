<?php

Route::group(['prefix' => 'v1', 'namespace' => 'v1'], function() 
{
	Route::get('/recipes', 'RecipeController@index');
	Route::get('recipes/recipe/{id}', 'RecipeController@show');
	Route::post('recipes/store', 'RecipeController@store');
	Route::post('recipes/recipe/{id}/update', 'RecipeController@update');
	Route::post('recipes/recipe/{id}/rate', 'RecipeController@rate');
	Route::get('recipesForCuisine/{cuisine}', 'RecipeController@getRecipesForCuisine');
});