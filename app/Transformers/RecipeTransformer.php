<?php

namespace App\Transformers;

class RecipeTransformer extends Transformer
{
	public function transform($recipe)
    {
		return 
		[
			'id' => $recipe->id,
			'title' => $recipe->title
		];
    }
}