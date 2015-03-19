<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";

    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=restaurant_db');

    $app->register(new Silex\Provider\TwigServiceProvider, array('twig.path' => __DIR__.'/../views'));

    //go to the homepage and display the list of all our Cuisines
    $app->get("/", function() use ($app) {
        $cuisine_array = Cuisine::getAll();
        return $app['twig']->render('index.twig', array('cuisine_array' => $cuisine_array));
    });


    //on the homepage when you click to add cuisine run this router
    $app->post("/cuisines", function() use ($app) {
        //create a new cuisine based on users input
        $new_cuisine = new Cuisine($_POST['cuisine']);
        $new_cuisine->save();

        $cuisine_array = Cuisine::getAll();

        return $app['twig']->render('index.twig', array('cuisine_array' => $cuisine_array));
    });

    //Find cuisine based on id
    $app->get("/cuisines/{id}", function($id) use ($app) {
        $new_cuisine = Cuisine::find($id);

        //get all of our restaurants
        $restaurants = Restaurant::getAll();
        return $app['twig']->render('view_cuisine.twig', array('cuisine' => $new_cuisine, 'restaurant_array' => $restaurants));
    });

    $app->post("/add_restaurant", function() use ($app) {
        $new_restaurant = new Restaurant($_POST['name'], $_POST['cuisine_id']);
        $new_restaurant->save();

        $new_cuisine = Cuisine::find($_POST['cuisine_id']);

        return $app['twig']->render('view_cuisine.twig', array('cuisine' => $new_cuisine));

    });

    //delete all of the cuisines and go to the homepage
    $app->post("/delete_cuisines", function() use ($app) {
        Cuisine::deleteAll();
        Restaurant::deleteAll();

        return $app['twig']->render('index.twig');
    });

    return $app;

?>
