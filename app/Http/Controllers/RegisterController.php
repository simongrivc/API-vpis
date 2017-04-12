<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller{

  
    public function registerStudent(Request $request){
        
             //dobi podatke o študentu
        //preveri pravilno strukturo emaila preveri podvajanje up imena in email naslova in šibkost gesla
        //vrni errorje če je kaj narobe drugače dodaj userja z šifriranim geslom
        //če ne dodaj v tabelo ter pošlji email z potrditvenim url jem v bazo dodaj potditev
        //naredi endpoint za potrditve

        //preverimo podvajanje email naslova in username-a

        if($request->input('name') && $request->input('surname') && $request->input('username') && $request->input('password') && $request->input('email'))
        {
             // ujemanje username-a ali email naslova
            $usernamesMatch = User::where('username', '=', $request->input('username'))->get();
           
            $emailMatch =  User::where('email', '=', $request->input('email'))->get();
           

            if(sizeOf($usernamesMatch)>0 || sizeOf($emailMatch)>0){
                //uporabnik že obstaja oz. se njegovi podatki podvajajo
                return response()->json('User duplication.');
            }

            //preverjanje ustreznosti gesla

            if (strlen($request->input('password')) < 8) {
                return response()->json('Password too short (at least 8 characters)!');
            }

            if (!preg_match("#[0-9]+#", $request->input('password'))) {
                return response()->json('Password must include at least one number!');
            }

            if (!preg_match("#[a-zA-Z]+#", $request->input('password'))) {
                return response()->json('Password must include at least one letter!');
            }     

            //če gre vse čez kreiraj uporabnika ter ga dodaj v tabelo
            /*$user = new User();
            $user->name = $request->input('name');
            $user->surname = $request->input('surname');
            $user->username = $request->input('username');
            $user->password = Hash::make($request->input('password'));
            $user->email = $request->input('email');
            //nastavimo da je uporabnik študent*/
            //$user->fk_user_role = 4;
            //nastavimo da študent še ni aktiviran dokler ne potrdi preko email računa svoj račun
           // $user->is_active = 0;
            //$user->save();

            //kreiram aktivacijsko kodo za link
            $activationCode = Crypt::encrypt('Time created:;'.time().';Time of exp.:;'. (time()+3600) .';'. $request->input('username'));
            
            /*$idActivationCodeUser = DB::table('user_activations')->insertGetId(
                ['activation_code' => $activationCode, 'send_time' => time()]
            );*/

            if($activationCode)
            {
                /*$id = DB::table('users')->insertGetId(
                    ['name' => $request->input('name'), 'surname' => $request->input('surname'), 'username' => $request->input('username'), 'password' => $request->input('password'), 'email' => $request->input('email'), 'fk_user_role' => 4, 'is_active' => 0, 'fk_activation_code' => $idActivationCodeUser]
                );*/
                //pošlji mail
              $recipients = ['simongrivc@gmail.com'];
                app('mail')->raw('This is a test message.', function ($message) use ($recipients) {
                    $message->subject('This is a test to see if emails are working');
                    $message->to($recipients);
                });


     

                return response()->json('Student created (mail sent to student): ' . $activationCode);
            }
            else
            {
                return response()->json("Activation code not generated error.");
            }
          

            //dodaj v tabelo user activations nov zapis za študenta ter pošli mail :TODO


            //$user = User::create($request->all());

        }   
         return  response()->json("Missing form data.");
       
       
    }

    public function registerUser(Request $request){
        

    }
    

   
}
?>
