<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Support\Facades\Mail;
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
                return response()->json(array('error' => 'user_duplication'),400);
            }

            //preverjanje ustreznosti gesla

            if (strlen($request->input('password')) < 8) {
                return response()->json(array('error' => 'password_to_short'),400);
            }

            if (!preg_match("#[0-9]+#", $request->input('password'))) {
                return response()->json(array('error' => 'password_one_number_required'),400);
            }

            if (!preg_match("#[a-zA-Z]+#", $request->input('password'))) {
                return response()->json(array('error' => 'password_one_letter_required'),400);
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
                    ['name' => $request->input('name'), 'surname' => $request->input('surname'), 'username' => $request->input('username'), 'password' =>  Hash::make($request->input('password')), 'email' => $request->input('email'), 'fk_user_role' => 4, 'is_active' => 1, 'fk_activation_code' => $idActivationCodeUser]
                );
                
                //popravi pri kreiranju is_active na 0 pošlji mail z aktivacijskim linkom :TODO
               
                return response()->json(array('success' => 'student_created'));
            }
            else
            {
                return response()->json(array('error' => 'activation_code_not_generated'),400);
            }
          

            //dodaj v tabelo user activations nov zapis za študenta ter pošli mail :TODO 

        }   
         return  response()->json(array('error' => 'missing_data'), 400);
       
       
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
                    return response()->json(array('error' => 'user_duplication'), 400);
                }

                //preverjanje ustreznosti gesla

                if (strlen($request->input('password')) < 8) {
                    return response()->json(array('error' => 'password_to_short'), 400);
                }

                if (!preg_match("#[0-9]+#", $request->input('password'))) {
                    return response()->json(array('error' => 'password_one_number_required'), 400);
                }

                if (!preg_match("#[a-zA-Z]+#", $request->input('password'))) {
                    return response()->json(array('error' => 'password_one_letter_required'), 400);
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
                        ['name' => $request->input('name'), 'surname' => $request->input('surname'), 'username' => $request->input('username'), 'password' =>  Hash::make($request->input('password')), 'email' => $request->input('email'), 'fk_user_role' => $request->input('user_role'), 'is_active' => 1, 'fk_activation_code' => $idActivationCodeUser]
                    );
                    
                    //popravi pri kreiranju is_active na 0 pošlji mail z aktivacijskim linkom :TODO
                    
                    //dodaj v tabelo user activations nov zapis za študenta ter pošli mail :TODO
                    /*Mail::send(['text' => 'view'], ['user' => $user], function ($m) use ($user) {
                        $m->from('hello@app.com', 'Sistem vpis');
            
                        $m->to($request->input('email'), $request->input('name'))->subject('Testni mail');
                     });*/
                   
                    return response()->json(array('success' => 'user_created'));
                }
                else
                {
                    return response()->json(array('error' => 'activation_code_not_generated'), 400);
                }
              


            }   
             return  response()->json(array('error' => 'missing_data'), 400);
        }
        
        return  response()->json(array('error' => 'no_admin_rights'), 401);
    }
    
    
    public function sendTestMail(){
        Mail::send(['text' => 'view'], ['user' => "testno"], function ($m) {
                        $m->from('tursic.klemen@gmail.com', 'Sistem vpis');
            
                        $m->to('tursic.klemen@gmail.com', 'Klemen')->subject('Testni mail');
                     });
        
        return response()->json(array('status' => 'dela'));
    }
    

   
}
?>
