<?php
 
namespace App\Http\Controllers;
 
use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class CitiesController extends Controller{

    public function index(){
 
        $cities = City::all();
        return response()->json($cities);
    }
    


}
?>
