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

    return $app->version() . " Dokumentacija: http://docs.sistemvpis.apiary.io/#reference/0/login/login";
    
});

//route groups

$app->post('login','LoginController@login');

//$app->get('token','LoginController@tokenExpired');

$app->post('token','LoginController@tokenExpired');

//registracija navadnega uporabnika
$app->post('register/student','RegisterController@registerStudent');

//user activation
$app->post('activation','UserController@activateUser');

//mock activation
$app->get('mockActivation','UserController@activateUserMock');

//registracija službe vpis in refentov
$app->post('register/user', ['middleware' => 'auth', 'uses' => 'RegisterController@registerUser']);

$app->post('mail','RegisterController@sendTestMail');


//programi vsi (nerazpisani)
//$app->get('application/study_programs', ['middleware' => 'auth', 'uses' => 'studyProgramsController@index']);
$app->get('application/study_programs', 'StudyProgramsController@index');
//program po id
$app->get('application/study_programs/{id}', 'StudyProgramsController@getStudyProgramById');

//dobi vse razpisane programe
$app->get('application/study_programs_calls', 'StudyProgramsController@getStudyProgramCalls');
//dobi vse fakultete
$app->get('application/vis_institutions', 'VisInstitutionsController@index');
$app->post('application/vis_institutions', 'VisInstitutionsController@index');



/*$app->post('uporabnik','UporabnikController@ustvariUporabnika');
 
$app->put('uporabnik/{id}','UporabnikController@urediUporabnika');
 	 
$app->delete('uporabnik/{id}','UporabnikController@izbrisiUporabnika');*/