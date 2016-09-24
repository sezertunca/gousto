<?php

use Faker\Factory as Faker;

class ApiTester extends TestCase
{
	protected $faker;

	function __construct()
	{
		$this->faker = Faker::create();
	}

	public function getJSON($uri)
    {
        return $this->call('GET', $uri)->getContent();
    }
}