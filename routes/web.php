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

//dodajanje in urejanje študijskega programa
$app->post('application/study_programs_calls/edit', 'StudyProgramsController@editStudyProgramCall');

//dobi vse fakultete
$app->get('application/vis_institutions', 'VisInstitutionsController@index');
//$app->post('application/vis_institutionsUniversity', 'VisInstitutionsController@getVisByUniversity');

//dobi vse občine
$app->get('application/cities', 'CitiesController@index');

//dobi vse države
$app->get('application/countries', 'CountriesController@index');


//dobi vse prijavnice (za prijavnice moraš biti prijavljen kot referent oz. služba vpis)
$app->post('application/applications', ['middleware' => 'auth', 'uses' => 'ApplicationsController@getApplications']);

//prijavnica po id
$app->get('application/applications/{id}', 'ApplicationsController@getApplicationsById');

//dobi šifrante univerz
$app->post('application/applications_user', 'ApplicationsController@getApplicationsUser');

//dobi šifrante univerz
$app->get('application/universities', 'UniversitiesController@index');

//dobi vse razpise
$app->get('application/group_calls', 'CallGroupsController@index');

//dobi vse šifrante za pogoje
$app->get('application/condition_codes', 'ConditionCodesController@index');

//endpoint klasius srv
$app->get('application/klasius_srv', 'KlasiusSrvController@index');
//način zaključka srednje šole
$app->get('application/MiddleSchoolCompletionTypes', 'MiddleSchoolCompletionTypeController@index');


//edit add prijavnica
$app->post('application/edit',  'ApplicationsController@editApplication');

//daj status prijavnice na deleted
$app->post('application/delete', 'ApplicationsController@deleteApplicationById');


//POGOJI<-------
//dodaj pogoje za razpisan program
$app->post('application/programs_call_conditions/add', 'ConditionsController@addConditionGroup');

//izbrisi pogoje za razpisan program
$app->post('application/programs_call_conditions/delete', 'ConditionsController@deleteConditionGroup');

//posodobi pogoje za razpisan program
//$app->post('application/programs_call_conditions/edit', 'ConditionsController@updateConditionGroup');
$app->post('application/programs_call_conditions/edit', 'ConditionsController@addConditionGroup');

//TODO
//dobi vse pogoje za razpisan program
//$app->get('application/programs_call_conditions/{id}', 'ProgramCallCondition@getProgramCallConditions');


/*$app->post('uporabnik','UporabnikController@ustvariUporabnika');
 
$app->put('uporabnik/{id}','UporabnikController@urediUporabnika');
 	 
$app->delete('uporabnik/{id}','UporabnikController@izbrisiUporabnika');*/