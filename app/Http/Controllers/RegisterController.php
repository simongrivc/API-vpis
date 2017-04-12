<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller{

  

    public function registerStudent(Request $request){

        if($request->input('name') && $request->input('surname') && $request->input('username') && $request->input('password') && $request->input('email'))
        {
             // ujemanje username-a ali email naslova
            $usernamesMatch = User::where('username', '=', $request->input('username'))->get();
           
            $emailMatch =  User::where('email', '=', $request->input('email'))->get();
           

            if(sizeOf($usernamesMatch)>0 || sizeOf($emailMatch)>0){
                //uporabnik že obstaja oz. se njegovi podatki podvajajo
                return response()->json('User duplication.',400);
            }

            //preverjanje ustreznosti gesla

            if (strlen($request->input('password')) < 8) {
                return response()->json('Password too short (at least 8 characters)!',400);
            }

            if (!preg_match("#[0-9]+#", $request->input('password'))) {
                return response()->json('Password must include at least one number!',400);
            }

            if (!preg_match("#[a-zA-Z]+#", $request->input('password'))) {
                return response()->json('Password must include at least one letter!',400);
            }     

            //če gre vse čez kreiraj uporabnika ter ga dodaj v tabelo

            //kreiram aktivacijsko kodo za link
            $activationCode = Crypt::encrypt('Time created:;'.time().';Time of exp.:;'. (time()+3600) .';'. $request->input('username'));
            
            $idActivationCodeUser = DB::table('user_activations')->insertGetId(
                ['activation_code' => $activationCode, 'send_time' => time()]
            );

            if($idActivationCodeUser)
            {
                $id = DB::table('users')->insertGetId(
                    ['name' => $request->input('name'), 'surname' => $request->input('surname'), 'username' => $request->input('username'), 'password' => $request->input('password'), 'email' => $request->input('email'), 'fk_user_role' => 4, 'is_active' => 1, 'fk_activation_code' => $idActivationCodeUser]
                );
                
                //popravi pri kreiranju is_active na 0 pošlji mail z aktivacijskim linkom :TODO
               
                return response()->json('Student created.');
            }
            else
            {
                return response()->json("Activation code not generated error.",400);
            }
          

            //dodaj v tabelo user activations nov zapis za študenta ter pošli mail :TODO 

        }   
         return  response()->json("Missing form data.", 400);
       
       
    }

    public function registerUser(Request $request){
        $user = Auth::user();
        //preveri da registrira administrator
        if($user->fk_user_role==1)
        {
            if($request->input('name') && $request->input('surname') && $request->input('username') && $request->input('password') && $request->input('email') && $request->input('user_role'))
            {
                 // ujemanje username-a ali email naslova
                $usernamesMatch = User::where('username', '=', $request->input('username'))->get();
               
                $emailMatch =  User::where('email', '=', $request->input('email'))->get();
               

                if(sizeOf($usernamesMatch)>0 || sizeOf($emailMatch)>0){
                    //uporabnik že obstaja oz. se njegovi podatki podvajajo
                    return response()->json('User duplication.', 400);
                }

                //preverjanje ustreznosti gesla

                if (strlen($request->input('password')) < 8) {
                    return response()->json('Password too short (at least 8 characters)!', 400);
                }

                if (!preg_match("#[0-9]+#", $request->input('password'))) {
                    return response()->json('Password must include at least one number!', 400);
                }

                if (!preg_match("#[a-zA-Z]+#", $request->input('password'))) {
                    return response()->json('Password must include at least one letter!', 400);
                }     

                //če gre vse čez kreiraj uporabnika ter ga dodaj v tabelo

                //kreiram aktivacijsko kodo za link
                $activationCode = Crypt::encrypt('Time created:;'.time().';Time of exp.:;'. (time()+3600) .';'. $request->input('username'));
                
                $idActivationCodeUser = DB::table('user_activations')->insertGetId(
                    ['activation_code' => $activationCode, 'send_time' => time()]
                );

                if($idActivationCodeUser)
                {
                    $id = DB::table('users')->insertGetId(
                        ['name' => $request->input('name'), 'surname' => $request->input('surname'), 'username' => $request->input('username'), 'password' => $request->input('password'), 'email' => $request->input('email'), 'fk_user_role' => $request->input('user_role'), 'is_active' => 1, 'fk_activation_code' => $idActivationCodeUser]
                    );
                    
                    //popravi pri kreiranju is_active na 0 pošlji mail z aktivacijskim linkom :TODO
                   
                    return response()->json('User created.');
                }
                else
                {
                    return response()->json("Activation code not generated error.", 400);
                }
              

                //dodaj v tabelo user activations nov zapis za študenta ter pošli mail :TODO 

            }   
             return  response()->json("Missing form data.", 400);
        }
        
        return  response()->json("This user doesn't have admin rights.", 401);
    }
    

   
}
?>
