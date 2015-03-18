<?php

    class Cuisine {

        private $food_type;


        function __construct($food)
        {
            $this->food_type = $food;
        }

        function setFoodType($new_food_type)
        {
            $this->food_type = (string) $new_food_type;
        }

        function getFoodType()
        {
            return $this->food_type;

        }

        function save()
        {

            $GLOBALS['DB']->exec("INSERT INTO cuisine (food_type) VALUES ('{$this->getFoodType()}');");
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisine_array = array();
            foreach($returned_cuisines as $cuisine) {
                $food_type = $cuisine['food_type'];
                $new_cuisine = new Cuisine($food_type);
                array_push($cuisine_array, $new_cuisine);
            }

            return $cuisine_array;
        }


        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine *");
        }
    }






 ?>
