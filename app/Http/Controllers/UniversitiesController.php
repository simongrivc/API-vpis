<?php
 
namespace App\Http\Controllers;
 
use App\University;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class UniversitiesController extends Controller{

    public function index(){
 
        $univerze = University::all();
        return response()->json($univerze);
    }
    


}
?>
