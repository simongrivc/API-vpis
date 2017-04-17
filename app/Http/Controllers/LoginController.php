<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Ip_log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller{

  
    public function login(Request $request){
         
         $ipAddress = '';

         if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
            $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                $ipAddress = trim($_SERVER['REMOTE_ADDR']);
            }
        }
        //preveri blokado ip-ja
        $ip_block_duration = 1; //duration in minutes
        $block_time_border = time() - ($ip_block_duration * 60);
        
        Ip_log::where('ip_number', '=', $ipAddress)->where('time_stamp', '<', $block_time_border)->delete();
        
        $ip_logs = Ip_log::where('ip_number', '=', $ipAddress)->get();
        
        if($ip_logs){
            if(count($ip_logs)>2)
                return response()->json(array('error' => 'ip_lock'),401);
        }
     
         //dobi podatke o uporabniškem imenu in emailu (vereficiraj)

            $user = User::where('username', '=', $request->input('username'))->first();
            
            // če user ni null kreiraj token in ga dodaj userju vrni toke
            if($user)
            {
                if(Hash::check($request->input('password'), $user->password))          
                {
                    $user->api_token = Crypt::encrypt('Time created:;'.time().';Time of exp.:;'. (time()+3600) .';'. $user->username);
                    //decript $decrypted = Crypt::decrypt($encryptedValue);
                    $user->last_login = time();
                    $user->save();

                    return response()->json($user);
                }
                
                $log = DB::table('ip_logs')->insertGetId(
                    ['ip_number' => $ipAddress, 'time_stamp' => time()]
                );

                return response()->json(array('error' => 'incorect_user_credentials'), 400);
            }
            else
            {
            // Check for X-Forwarded-For headers and use those if found
                $log = DB::table('ip_logs')->insertGetId(
                    ['ip_number' => $ipAddress]
                );
               
                return response()->json(array('error' => 'incorect_user_credentials'), 400);
            }
       
    }

    public function tokenExpired(Request $request){
        $header = $request->header('Api-Token');

        if($header)
        {
         $decrypted = Crypt::decrypt($header);
         $podatkiToken = explode(";", $decrypted);
         if($podatkiToken[3]>time())
            return response()->json(array('success' => 'token_active'));
         else
            return response()->json(array('error' => 'token_expired'),400);
        }
        else 
            return response()->json(array('error' => 'missing_token'),400);
    }
}
?>
