<?php
 
namespace App\Http\Controllers;
 
use App\CallGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class CallGroupsController extends Controller{

    public function index(){
 
        $callgroups = CallGroup::all();
        return response()->json($callgroups);
    }
    


}
?>
