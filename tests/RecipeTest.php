<?php

// User Arrange, Act, Assert

class RecipeTest extends ApiTester
{
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
