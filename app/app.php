<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=restaurant_db');

    $app->register(new Silex\Provider\TwigServiceProvider, array('twig.path' => __DIR__.'/../views'));


    //enables patch route method
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

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

    //patch route
    $app->patch("/cuisines/{id}", function($id) use ($app) {
        $new_cuisine = Cuisine::find($id);
        $new_cuisine->update($_POST['name']);
        $restaurants = Restaurant::getAll();
        return $app['twig']->render('view_cuisine.twig', array('cuisine' => $new_cuisine, 'restaurant_array' => $restaurants));

    });

    //add a restaurant to a particular cuisine
    $app->post("/add_restaurant", function() use ($app) {
        $new_restaurant = new Restaurant($_POST['name'], $_POST['cuisine_id']);
        $new_restaurant->save();

        $new_cuisine = Cuisine::find($_POST['cuisine_id']);

        return $app['twig']->render('view_cuisine.twig', array('cuisine' => $new_cuisine, 'restaurant_array' => Restaurant::getAll()));

    });

    //delete all of the cuisines and go to the homepage
    $app->post("/delete_all", function() use ($app) {
        Cuisine::deleteAll();
        Restaurant::deleteAll();

        return $app['twig']->render('index.twig');
    });

    //delete all the restaurants out of a specific cuisine
    $app->post("/delete_cuisine", function() use ($app) {
        $new_cuisine = Cuisine::find($_POST['cuisine_id']);

        $new_cuisine->delete();

        return $app['twig']->render('index.twig');
    });

    //edit a cuisine
    $app->get("/edit_cuisine/{id}", function($id) use ($app) {
        $new_cuisine = Cuisine::find($id);

        return $app['twig']->render('edit_cuisine.twig', array('cuisine' => $new_cuisine));

    });

    return $app;

?>
