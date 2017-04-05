<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/
use Illuminate\Http\Request;
$app = require __DIR__.'/../bootstrap/app.php';

class Usr extends \Illuminate\Database\Eloquent\Model {  
  protected $table = 'Uporabnik';
}
/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/



$app->get('foo', function () {
    //return 'Hello World ' . $results = Uporabnik::select("SELECT * FROM Uporabnik");;
   // return response()->json(Usr::all());
});

$app->run();