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
use Mail;
    //return $app->version();
     Mail::raw('Raw string email', function($msg) { $msg->to(['simongrivc@gmail.com']); $msg->from(['frismrpo@gmail.com']); });
    return 'logged email via mailtrap.io...';
});

//route groups

$app->post('login','LoginController@login');

//$app->get('token','LoginController@tokenExpired');

$app->post('token','LoginController@tokenExpired');

//registracija navadnega uporabnika
$app->post('register/student','RegisterController@registerStudent');


//registracija službe vpis in refentov
$app->post('register/user', ['middleware' => 'auth', 'uses' => 'RegisterController@registerUser']);

$app->post('mail','RegisterController@sendTestMail');

$app->post('mail1','RegisterController@sendTestMail1');

//programi 
//$app->get('application/study_programs', ['middleware' => 'auth', 'uses' => 'studyProgramsController@index']);
$app->get('application/study_programs', 'StudyProgramsController@index');

$app->get('application/study_programs/{id}', 'StudyProgramsController@getStudyProgramById');



/*$app->post('uporabnik','UporabnikController@ustvariUporabnika');
 
$app->put('uporabnik/{id}','UporabnikController@urediUporabnika');
 	 
$app->delete('uporabnik/{id}','UporabnikController@izbrisiUporabnika');*/