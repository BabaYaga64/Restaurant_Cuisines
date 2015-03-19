<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";

    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=restaurant_db');

    $app->get("/", function() {
        return "Hello FRIEND!";
    });

    return $app;

?>
