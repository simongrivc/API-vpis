<?php
 
namespace App\Http\Controllers;
 
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class CountriesController extends Controller{

    public function index(){
 
        $countries = Country::all();
        return response()->json($countries);
    }
    


}
?>
