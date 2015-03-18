<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";

    $DB = new PDO('pgsql:host=localhost;dbname=restaurant_test');

    class CuisineTest extends PHPUnit_Framework_TestCase
    {

        //clear the database between tests;
        function tearDown()
        {
            Cuisine::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $food_type = "Mexican";
            $test_cuisine = new Cuisine($food_type);

            //Act
            $test_cuisine->save();

            //Assert
            $result = Cuisine::getAll();
            $this->assertEquals($test_cuisine, $result[0]);
        }

        function test_deleteAll()
        {
            //arrange
            $food = "Mexican";
            $food2 = "Egytian";

            $test_cuisine = new Cuisine($food);
            $test_cuisine2 = new Cuisine($food2);

            $test_cuisine->save();
            $test_cuisine2->save();

            //Act
            Cuisine::deleteAll();

            //assert
            $result = Cuisine::getAll();
            $this->assertEquals([], $result);


        }
    }

?>
