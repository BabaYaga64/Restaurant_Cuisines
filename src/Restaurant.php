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

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        //deletes single object based on current iteration of id
        function delete() {
            $GLOBALS['DB']->exec("DELETE FROM restaurants * WHERE id = {$this->getId()};");
        }

        //Get a row out based on the id
        static function find($search_id)
        {
            $row_out = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE id = {$search_id};");
            $new_restaurant = null;
            foreach($row_out as $out) {
                $id = $out['id'];
                $name = $out['name'];
                $cuis_id = $out['cuisine_id'];
                $new_restaurant = new Restaurant($name, $cuis_id, $id);

            }
            return $new_restaurant;
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
