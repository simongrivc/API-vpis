<?php
 
namespace App\Http\Controllers;
 
use App\ConditionCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class ConditionCodesController extends Controller{

    public function index(){
 
        $conditionCodes = ConditionCode::all();
        return response()->json($conditionCodes);
    }
    


}
?>
