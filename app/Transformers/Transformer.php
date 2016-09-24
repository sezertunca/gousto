<?php

namespace App\Transformers;

abstract class Transformer
{
	/**
	* Transform a collection of items
	* @param $items
	* @return array
	*/
	public function transformCollection($items)
    {
    	return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);
}