<?php
 
namespace App\Http\Controllers;
 
use App\Uporabnik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

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
       /* $uporabnik = Auth::user();
        return response()->json($uporabnik);*/

         $this->validate($request, [
            'ImeUporabnik'    => 'required|max:255',
        ]);

        try {

            if (! $token = $this->jwt->attempt($request->only('ImeUporabnik'))) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }

        return response()->json(compact('token'));
 
    }
}
?>
