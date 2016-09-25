<?php

/**
* RecipeTest.php
* Gousto API Test
*
* Created by Sezer Tunca on 24/09/2016.
* Copyright © 2016 Sezer Tunca. All rights reserved.
* Created for Gousto.
*/

use App\Recipe;

// User Arrange, Act, Assert

class RecipeTest extends ApiTester
{        
    public function setUp()
    {
        parent::setUp();
        
        // Generate fake test data
        $path = storage_path('app/public/data-test.json');
        if (!File::exists( $path ))
        {
            $fakeRecipes = 
            [
                ["id"=>"1","created_at"=>"30/06/2015 17:58:00","updated_at"=>"30/06/2015 17:58:00","box_type"=>"vegetarian","title"=>"Sweet Chilli and Lime Beef on a Crunchy Fresh Noodle Salad","slug"=>"sweet-chilli-and-lime-beef-on-a-crunchy-fresh-noodle-salad","short_title"=>"","marketing_description"=>"Here we've used onglet steak which is an extra flavoursome cut of beef that should never be cooked past medium rare. So if you're a fan of well done steak, this one may not be for you. However, if you love rare steak and fancy trying a new cut, please be","calories_kcal"=>"401","protein_grams"=>"12","fat_grams"=>"35","carbs_grams"=>"0","bulletpoint1"=>"","bulletpoint2"=>"","bulletpoint3"=>"","recipe_diet_type_id"=>"meat","season"=>"all","base"=>"noodles","protein_source"=>"beef","preparation_time_minutes"=>"35","shelf_life_days"=>"4","equipment_needed"=>"Appetite","origin_country"=>"Great Britain","recipe_cuisine"=>"asian","in_your_box"=>"","gousto_reference"=>"59","rate"=>null],
                ["id"=>"2","created_at"=>"30/06/2015 17:58:00","updated_at"=>"30/06/2015 17:58:00","box_type"=>"gourmet","title"=>"Tamil Nadu Prawn Masala","slug"=>"tamil-nadu-prawn-masala","short_title"=>"","marketing_description"=>"Tamil Nadu is a state on the eastern coast of the southern tip of India. Curry from there is particularly famous and it's easy to see why. This one is brimming with exciting contrasting tastes from ingredients like chilli powder, coriander and fennel seed","calories_kcal"=>"524","protein_grams"=>"12","fat_grams"=>"22","carbs_grams"=>"0","bulletpoint1"=>"Vibrant & Fresh","bulletpoint2"=>"Warming, not spicy","bulletpoint3"=>"Curry From Scratch","recipe_diet_type_id"=>"fish","season"=>"all","base"=>"pasta","protein_source"=>"seafood","preparation_time_minutes"=>"40","shelf_life_days"=>"4","equipment_needed"=>"Appetite","origin_country"=>"Great Britain","recipe_cuisine"=>"italian","in_your_box"=>"king prawns, basmati rice, onion, tomatoes, garlic, ginger, ground tumeric, red chilli powder, ground cumin, fresh coriander, curry leaves, fennel seeds","gousto_reference"=>"58","rate"=>null],
                ["id"=>"3","created_at"=>"30/06/2015 17:58:00","updated_at"=>"30/06/2015 17:58:00","box_type"=>"vegetarian","title"=>"Umbrian Wild Boar Salami Ragu with Linguine","slug"=>"umbrian-wild-boar-salami-ragu-with-linguine","short_title"=>"","marketing_description"=>"This delicious pasta dish comes from the Italian region of Umbria. It has a smoky and intense wild boar flavour which combines the earthy garlic, leek and onion flavours, while the chilli flakes add a nice deep aroma. Enjoy within 5-6 days of delivery.","calories_kcal"=>"609","protein_grams"=>"17","fat_grams"=>"29","carbs_grams"=>"0","bulletpoint1"=>"","bulletpoint2"=>"","bulletpoint3"=>"","recipe_diet_type_id"=>"meat","season"=>"all","base"=>"pasta","protein_source"=>"pork","preparation_time_minutes"=>"35","shelf_life_days"=>"4","equipment_needed"=>"Appetite","origin_country"=>"Great Britain","recipe_cuisine"=>"british","in_your_box"=>"","gousto_reference"=>"1","rate"=>null]
            ];

            $fakeRecipes = json_encode($fakeRecipes);
            File::put($path,$fakeRecipes);
        }
    }

    
    public function tearDown()
    {
        // Delete the fake data created for tests
        $path = storage_path('app/public/data-test.json');
        if (File::exists($path))
        {
            File::delete($path);
        }
    }

    /**
     * @test
     */
    public function it_fetches_all_recipes()
    {
        $this->getJSON('api/v1/recipes');
        $this->assertResponseOk();
    }

    /**
     * @test
     */
    public function it_fetches_single_recipe_that_exists()
    {
        $this->getJSON('api/v1/recipes/1');
        $this->assertResponseOk();
    }

    /**
     * @test
     */
    public function it_tries_to_fetch_single_recipe_that_does_not_exist()
    {
        $this->getJSON('api/v1/recipes/100');
        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function it_rates_recipe_with_non_integer()
    {
        $this->call('POST', 'api/v1/recipes/1/rate', ['value' => 'nonInteger']);
        $this->assertResponseStatus(403);
    }

    /**
     * @test
     */
    public function it_rates_recipe_with_not_valid_integer()
    {
        $this->call('POST', 'api/v1/recipes/1/rate', ['value' => 100]);
        $this->assertResponseStatus(403);
    }

    /**
     * @test
     */
    public function it_tries_to_store_new_recipe_with_no_only_title()
    {
        $this->call('POST', 'api/v1/recipes/store', ['title' => 'Test recipe title']);
        $this->assertResponseStatus(403);
    }

    /**
     * @test
     */
    public function it_checks_the_total_number_of_test_recipes()
    {
        $recipes = json_decode(file_get_contents(storage_path('app/public/data-test.json')));
        $this->assertEquals(3, count($recipes));
    }

    /**
     * @test
     */
    public function it_tries_to_update_recipe_with_no_info()
    {
        $this->call('POST', 'api/v1/recipes/1/update', []);
        $this->assertResponseStatus(403);
    }
}
