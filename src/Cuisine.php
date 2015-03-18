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

        }

        static function getAll()
        {
            
        }






    }






 ?>
