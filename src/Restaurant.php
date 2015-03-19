<?php

    class Restaurant
    {

        private $name;
        private $id;
        private $cuisine_id;
        private $rating;

        function __construct($name, $cuisine_id, $rating = 0, $id = null)
        {
            $this->name = $name;
            $this->cuisine_id = $cuisine_id;
            $this->id = $id;
            $this->rating = $rating;
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

        function setCuisineId($new_id)
        {
            $this->cuisine_id = $new_id;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function setRating($new_rating)
        {
            $this->rating = $new_rating;
        }

        function getRating()
        {
            return $this->rating;
        }

        function save()
        {

            $statement = $GLOBALS['DB']->query("INSERT INTO restaurants (name, cuisine_id, rating) VALUES ('{$this->getName()}', {$this->getCuisineId()}, {$this->getRating()}) RETURNING id;");
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
                $rating = $out['rating'];
                $new_restaurant = new Restaurant($name, $cuis_id, $rating, $id);

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
                $rating = $restaurant['rating'];
                $new_restaurant = new Restaurant($name, $cuis_id, $rating, $id);
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
