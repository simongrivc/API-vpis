<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {

    return $app->version();
});

$app->get('foo', function () {
<<<<<<< HEAD
    return 'Hello World 2' . $results = DB::select("SELECT * FROM Uporabnik");;
=======
    //return 'Hello World ' . $results = Uporabnik::select("SELECT * FROM Uporabnik");;
    return response()->json(Uporabnik::all());
>>>>>>> origin/master
});
