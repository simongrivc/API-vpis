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

//route groups

$app->post('login','LoginController@login');

$app->post('token','LoginController@tokenExpired');

//$app->get('login', ['middleware' => 'auth', 'uses' => 'LoginController@login']);

/*$app->post('uporabnik','UporabnikController@ustvariUporabnika');
 
$app->put('uporabnik/{id}','UporabnikController@urediUporabnika');
 	 
$app->delete('uporabnik/{id}','UporabnikController@izbrisiUporabnika');*/