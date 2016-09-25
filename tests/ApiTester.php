<?php

/**
* ApiTester.php
* Gousto API Test
*
* Created by Sezer Tunca on 24/09/2016.
* Copyright © 2016 Sezer Tunca. All rights reserved.
* Created for Gousto.
*/


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