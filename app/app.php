<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";

    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=restaurant_db');

    $app->register(new Silex\Provider\TwigServiceProvider, array('twig.path' => __DIR__.'/../views'));

    //go to the homepage and display the list of all our Cuisines
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig');
    });


    //on the homepage when you click to add cuisine run this router
    $app->post("/cuisines", function() use ($app) {
        //create a new cuisine based on users input
        $new_cuisine = new Cuisine($_POST['cuisine']);
        $new_cuisine->save();

        $cuisine_array = Cuisine::getAll();

        return $app['twig']->render('index.twig', array('cuisine_array' => $cuisine_array));
    });

    return $app;

?>
