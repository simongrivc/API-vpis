<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Ip_log;
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
            $user->api_token = Crypt::encrypt('Time created:;'.time().';Time of exp.:;'. (time()+3600) .';'. $user->username);
            //decript $decrypted = Crypt::decrypt($encryptedValue);
            $user->last_login = time();
            $user->save();

            return response()->json($user);
        }
        else
        {
            $ip=Request::ip();
            $log = new Ip_log;
            $log->ip_number($ip);
            $log->save();
            return response()->json('Incorect user credentials.');
        }
       
    }

    public function tokenExpired(Request $request){
        $header = $request->header('Api-Token');

        if($header)
        {
         $decrypted = Crypt::decrypt($header);
         $podatkiToken = explode(";", $decrypted);
         if($podatkiToken[3]>time())
            return response()->json('Token is active.');
         else
            return response()->json('Token expired.');
        }
        else 
            return response()->json('No token to inspect.');
    }
}
?>
