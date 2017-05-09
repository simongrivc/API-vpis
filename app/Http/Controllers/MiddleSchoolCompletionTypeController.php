<?php
 
namespace App\Http\Controllers;
 
use App\MiddleSchoolCompletionType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class MiddleSchoolCompletionTypeController extends Controller{

    public function index(){
 
        $MiddleSchoolCompletionType = MiddleSchoolCompletionType::all();
        return response()->json($MiddleSchoolCompletionType);
    }
    


}
?>
