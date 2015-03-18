<?php

    class Restaurant
    {

        private $name;
        private $id;
        private $cuisine_id;


        function __construct($name, $cuisine_id, $id = null)
        {
            $this->name = $name;
            $this->cuisine_id = $cuisine_id;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
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

            $statement = $GLOBALS['DB']->query("INSERT INTO restaurants (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function find()
        {

        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
            $restaurant_array = array();
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $id = $restaurant['id'];
                $cuis_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant($name, $cuis_id, $id);
                array_push($restaurant_array, $new_restaurant);
            }
            return $restaurant_array;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants *;");
        }
    }



 ?>
