<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";

    $DB = new PDO('pgsql:host=localhost;dbname=restaurant_db');

    class CuisineTest extends PHPUnit_Framework_TestCase
    {

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
    }

?>
