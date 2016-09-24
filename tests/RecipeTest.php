<?php


class RecipeTest extends ApiTester
{
    /**
     * @test
     * 
     */
    public function it_fetches_all_recipes()
    {
        // Arrange
        // Act
        $this->getJSON('api/v1/recipes');
        // Assert

        $this->assertResponseOk();
    }
}
