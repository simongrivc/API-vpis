<?php
 
namespace App\Http\Controllers;
 
use App\KlasiusSrv;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class KlasiusSrvController extends Controller{

    public function index(){
 
        $KlasiusSrv = KlasiusSrv::all();
        return response()->json($KlasiusSrv);
    }
    


}
?>
