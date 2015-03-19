<?php

    class Cuisine {

        private $food_type;
        private $id;


        function __construct($food, $id = null)
        {
            $this->food_type = $food;
            $this->id = $id;
        }

        function setFoodType($new_food_type)
        {
            $this->food_type = (string) $new_food_type;
        }

        function getFoodType()
        {
            return $this->food_type;

        }


        function getId()
        {
            return $this->id;
        }


        function setId($new_id)
        {
            $this->id = $new_id;

        }

        function save()
        {

            $statement = $GLOBALS['DB']->query("INSERT INTO cuisine (food_type) VALUES ('{$this->getFoodType()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisine_array = array();
            foreach($returned_cuisines as $cuisine) {
                $food_type = $cuisine['food_type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($food_type, $id);
                array_push($cuisine_array, $new_cuisine);
            }

            return $cuisine_array;
        }


        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine *;");
        }

        static function find($search_id)
        {
            $returned_cuisine = $GLOBALS['DB']->query("SELECT * FROM cuisine WHERE id = {$search_id};");

            $new_cuisine = null;
            foreach($returned_cuisine as $cuisine) {
                $food_type = $cuisine['food_type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($food_type, $id);
            }

            return $new_cuisine;

        }


    }






 ?>
