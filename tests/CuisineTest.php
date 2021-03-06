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
        protected function tearDown()
        {
            Cuisine::deleteAll();
        }


        //Saves the cuisine object information into the database.
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


        //Clears the cuisine table of all cuisine objects.
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


        //Pulls information out of database and recreates cuisine objects.
        function test_getAll()
        {
            //arrange
            $food = "Mexican";
            $food2 = "Thai";

            $test_cuisine = new Cuisine($food);
            $test_cuisine2 = new Cuisine($food2);
            $test_cuisine->save();
            $test_cuisine2->save();

            //act
            $result = Cuisine::getAll();

            //assert
            $this->assertEquals([$test_cuisine, $test_cuisine2], $result);
        }

        //Tests whether the id function works.
        function test_getId()
        {
            //Arrange
            $food = "American";

            $id = 1;
            $test_cuisine = new Cuisine($food, $id);

            //Act
            $result = $test_cuisine->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        //tests whther the setId function properly changes the Cuisine objects
        //id
        function test_setId()
        {
            //arrange
            $food = "American";

            $id = 1;
            $test_cuisine = new Cuisine($food, $id);

            //act
            $test_cuisine->setId(3);

            //assert
            $result = $test_cuisine->getId();
            $this->assertEquals(3, $result);
        }

        //find a particular Cuisine class
        function test_find()
        {
            //arrange
            $food = "Belgium";

            $test_cuisine = new Cuisine($food);
            $test_cuisine->save();

            $test_id = $test_cuisine->getId();

            //act
            $result = Cuisine::find($test_id);

            //assert
            $this->assertEquals($test_cuisine, $result);
        }

        function test_findNull()
        {
            //arrange
            $id = 20000;

            //act
            $result = Cuisine::find($id);

            //assert
            $this->assertEquals(null, $result);
        }

        //test to see if we can update a single object
        function test_update() {

            //arrange
            $food = "Mexican";
            $new_cuisine = "Mongolian";

            $test_cuisine = new Cuisine($food);
            $test_cuisine->save();

            //act
            $test_cuisine->update($new_cuisine);

            //assert
            $this->assertEquals($new_cuisine, $test_cuisine->getFoodType());
        }

        //test to see if we can delete single objects
        function test_delete() {

            //arrange
            $test_cuisine = new Cuisine("American");
            $test_cuisine->save();

            //act
            $test_cuisine->delete();

            $result = Cuisine::getAll();
            //assert
            $this->assertEquals([], $result);
        }
    }

?>
