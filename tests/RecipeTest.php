<?php

// User Arrange, Act, Assert

class RecipeTest extends ApiTester
{
    
    // See the total number of recipes
    // Add a recipe and see the total number after adding
    // Update recipe and see if it's updated
    // Rate a recipe
    // Try to rate a recipe that is less than 1 or more than 5;


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
    public function it_fetches_single_recipe_that_not_exist()
    {
        $this->getJSON('api/v1/recipes/100');
        $this->assertResponseStatus(404);
    }

}
