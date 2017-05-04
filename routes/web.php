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

//dobi vse razpisane programe(aktivne)
$app->get('application/study_programs_calls/', 'StudyProgramsController@getStudyProgramCallsActive');

//dodaj za vse razpisane programe na posameznem razpisu
$app->get('application/study_programs_calls/{id}', 'StudyProgramsController@getStudyProgramCallsActiveFromGroup');

//brisanje razpisanega programa
$app->post('application/study_programs_calls/delete', 'StudyProgramsController@deleteStudyProgramCallById');

//dobi vse fakultete
$app->get('application/vis_institutions', 'VisInstitutionsController@index');
//$app->post('application/vis_institutionsUniversity', 'VisInstitutionsController@getVisByUniversity');

//dobi vse občine
$app->get('application/cities', 'CitiesController@index');

//dobi vse prijavnice (za prijavnice moraš biti prijavljen kot referent oz. služba vpis)
$app->post('application/applications', ['middleware' => 'auth', 'uses' => 'ApplicationsController@getApplications']);

//dobi šifrante univerz
$app->get('application/universities', 'UniversitiesController@index');

//dobi vse razpise
$app->get('application/group_calls', 'CallGroupsController@index');

//dobi vse šifrante za pogoje
$app->get('application/condition_codes', 'ConditionCodesController@index');


/*$app->post('uporabnik','UporabnikController@ustvariUporabnika');
 
$app->put('uporabnik/{id}','UporabnikController@urediUporabnika');
 	 
$app->delete('uporabnik/{id}','UporabnikController@izbrisiUporabnika');*/