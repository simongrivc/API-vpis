<?php
 
namespace App\Http\Controllers;
 
use App\Uporabnik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller{

    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function ustvariUporabnika(Request $request){
 
        $uporabnik = Uporabnik::create($request->all());
 
        return response()->json($uporabnik);
 
    }
 
    public function urediUporabnika(Request $request, $id){

        $uporabnik = Uporabnik::find($id);
        $uporabnik->ImeUporabnika = $request->input('ImeUporabnika');
        $uporabnik->save();
 
        return response()->json($uporabnik);
    }  

    public function izbrisiUporabnika($id){
        $uporabnik = Uporabnik::find($id);
        $Uporabnik->delete();
 
        return response()->json('Uporabnik odstranjen uspešno.');
    }

    public function login(Request $request){
 
        //$uporabniki = Uporabnik::all();
        $uporabnik = Auth::user();
        return response()->json($uporabnik);

    }
}
?>
