<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

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
            $user->api_token = Crypt::encrypt('tokenuser,time');
            //decript $decrypted = Crypt::decrypt($encryptedValue);
            $user->save();
            return response()->json($user);
        }
        else
            return response()->json('Incorect user credentials.');
       
    }

    public function tokenExpired(Request $request){
        $header = $request->header('Api-Token');

        if($header)
        {
         $decrypted = Crypt::decrypt($header);
         return response()->json($decrypted);
        }
        else 
            return response()->json('No token to inspect.');
    }
}
?>
