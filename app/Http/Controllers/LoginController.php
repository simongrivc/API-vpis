<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{

  
    public function login(Request $request){
        //dobi podatke o uporabniškem imenu in emailu (vereficiraj)

        $user = User::where([
                    ['username', '=', $request->input('username')],
                    ['password', '=', $request->input('password')],
                ])->first();

        // če user ni null kreiraj token in ga dodaj userju vrni toke
        if($user)
        {
            $user->api_token = "novtoken";
            $user->save();
        }
        return response()->json($user);
    }
}
?>
