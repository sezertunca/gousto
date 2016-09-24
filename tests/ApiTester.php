<?php

use Faker\Factory as Faker;

class ApiTester extends TestCase
{
	protected $faker;

	function __construct()
	{
		$this->faker = Faker::create();
	}

	public function getJSON($uri, $method = 'GET')
    {
        return json_decode($this->call($method, $uri)->getContent());
    }
}