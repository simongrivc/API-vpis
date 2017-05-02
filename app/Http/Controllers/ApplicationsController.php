<?php
 
namespace App\Http\Controllers;
 
use App\Application;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class ApplicationsController extends Controller{

    public function getApplications(){
 		$user = Auth::user();
 		return $user;

 		//return "blabla";
        //$application = Application::all();
        //return response()->json($application);
    }
    


}
?>
