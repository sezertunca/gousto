<?php

namespace App;

class Recipe
{
    public $id;
	public $created_at;
	public $updated_at;
	public $box_type;
	public $title;
	public $slug;
	public $short_title;
	public $marketing_description;
	public $calories_kcal;
	public $protein_grams;
	public $fat_grams;
	public $carbs_grams;
	public $bulletpoint1;
	public $bulletpoint2;
	public $bulletpoint3;
	public $recipe_diet_type_id;
	public $season;
	public $base;
	public $protein_source;
	public $preparation_time_minutes;
	public $shelf_life_days;
	public $equipment_needed;
	public $origin_country;
	public $recipe_cuisine;
	public $in_your_box;
	public $gousto_reference;
    public $rate;

	public function __construct($id, $created_at, $updated_at, $box_type, $title, $slug, $short_title, $marketing_description, $calories_kcal, $protein_grams, $fat_grams, $carbs_grams, $bulletpoint1, $bulletpoint2, $bulletpoint3, $recipe_diet_type_id, $season, $base, $protein_source, $preparation_time_minutes, $shelf_life_days, $equipment_needed, $origin_country, $recipe_cuisine, $in_your_box, $gousto_reference)
	{
		$this->id = $id;
		$this->created_at = $created_at;
		$this->updated_at = $updated_at;
		$this->box_type = $box_type;
		$this->title = $title;
		$this->slug = $slug;
		$this->short_title = $short_title;
		$this->marketing_description = $marketing_description;
		$this->calories_kcal = $calories_kcal;
		$this->protein_grams = $protein_grams;
		$this->fat_grams = $fat_grams;
		$this->carbs_grams = $carbs_grams;
		$this->bulletpoint1 = $bulletpoint1;
		$this->bulletpoint2 = $bulletpoint2;
		$this->bulletpoint3 = $bulletpoint3;
		$this->recipe_diet_type_id = $recipe_diet_type_id;
		$this->season = $season;
		$this->base = $base;
		$this->protein_source = $protein_source;
		$this->preparation_time_minutes = $preparation_time_minutes;
		$this->shelf_life_days = $shelf_life_days;
		$this->equipment_needed = $equipment_needed;
		$this->origin_country = $origin_country;
		$this->recipe_cuisine = $recipe_cuisine;
		$this->in_your_box = $in_your_box;
		$this->gousto_reference = $gousto_reference;
	}
}
