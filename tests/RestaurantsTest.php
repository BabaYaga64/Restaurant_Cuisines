<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";

    $DB = new PDO('pgsql:host=localhost;dbname=restaurant_test');

    class RestaurantsTest extends PHPUnit_Framework_TestCase
    {

        //clear the database between tests;
        protected function tearDown()
        {
            Restaurant::deleteAll();
        }


        //Saves the restaurant object information into the database.
        function test_save()
        {
            //Arrange
            $name = "Mi Mero Mole";
            $cuis_id = null;
            $test_restaurant = new Restaurant($name, $cuis_id);

            //Act
            $test_restaurant->save();

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals($test_restaurant, $result[0]);
        }


        //Clears the restaurant table of all restaurant objects.
        function test_deleteAll()
        {
            //arrange
            $name = "Mi Mero Mole";
            $name2 = "Yabayaba";
            $cuis_id = 1;
            $cuis_id2 = 2;

            $test_restaurant = new Restaurant($name, $cuis_id);
            $test_restaurant2 = new Restaurant($name2, $cuis_id2);

            $test_restaurant->save();
            $test_restaurant2->save();

            //Act
            Restaurant::deleteAll();

            //assert
            $result = Restaurant::getAll();
            $this->assertEquals([], $result);


        }


        //Pulls information out of database and recreates restaurant objects.
        function test_getAll()
        {
            //arrange
            $name = "Mi Mero Mole";
            $name2 = "Red Onion";
            $cuis_id = null;
            $cuis_id2 = null;

            $test_restaurant = new Restaurant($name, $cuis_id);
            $test_restaurant2 = new Restaurant($name2, $cuis_id2);
            $test_restaurant->save();
            $test_restaurant2->save();

            //act
            $result = Restaurant::getAll();

            //assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        //Tests whether the id function works.
        function test_getId()
        {
            //Arrange
            $name = "Burgerville";

            $id = 1;
            $cuis_id = 31;
            $test_restaurant = new Restaurant($name, $cuis_id, $id);

            //Act
            $result = $test_restaurant->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        //tests whther the setId function properly changes the restaurant objects
        //id
        function test_setId()
        {
            //arrange
            $name = "Burgerville";

            $id = 1;
            $test_restaurant = new Restaurant($name, $id);

            //act
            $test_restaurant->setId(3);

            //assert
            $result = $test_restaurant->getId();
            $this->assertEquals(3, $result);

        }

        // function test_find()
        // {
        //     //arrange
        //     $name = "PhoTon";
        //     $name2 = "Red Onion";
        //     $cuis_id = null;
        //     $cuis_id2 = null;
        //
        //     $test_restaurant = new Restaurant($name, $cuis_id);
        //     $test_restaurant2 = new Restaurant($name2, $cuis_id2);
        //     $test_restaurant->save();
        //     $test_restaurant2->save();
        //
        //     //act
        //     $result = Restaurant::find($test_restaurant->getId());
        //
        //     //assert
        //     $this->assertEquals($test_restaurant, $result);
        // }
    }

?>
