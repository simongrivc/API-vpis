<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RegisterController extends Controller{

  
    public function registerStudent(Request $request){
        
        //dobi podatke o študentu
        //preveri pravilno strukturo emaila preveri podvajanje up imena in email naslova in šibkost gesla
        //vrni errorje če je kaj narobe drugače dodaj userja z šifriranim geslom
        //če ne dodaj v tabelo ter pošlji email z potrditvenim url jem v bazo dodaj potditev
        //naredi endpoint za potrditve

       
       
    }

    public function registerUser(Request $request){
        
        //dobi podatke o študentu
        //preveri pravilno strukturo emaila preveri podvajanje up imena in email naslova in šibkost gesla
        //vrni errorje če je kaj narobe drugače dodaj userja z šifriranim geslom
        //če ne dodaj v tabelo ter pošlji email z potrditvenim url jem v bazo dodaj potditev
        //naredi endpoint za potrditve

        //preverimo podvajanje email naslova in username-a

        if($request->input('name') && $request->input('surname') && $request->input('email') && $request->input('password') && $request->input('email'))
        {
            $usernamesMatch = User::where(['username', '=', $request->input('username')])->get();
            // ujemanje username-a ali email naslova
            $results = User::where($usernamesMatch)
                ->orWhere(['email', '=', $request->input('email')])
                ->get();

            if(sizeOf($results)>0){
                //uporabnik že obstaja oz. se njegovi podatki podvajajo
                return response()->json('User duplication.');
            }

            //preverjanje ustreznosti gesla

            if (strlen($request->input('password')) < 8) {
                return response()->json('Password too short!');
            }

            if (!preg_match("#[0-9]+#", $request->input('password'))) {
                return response()->json('Password must include at least one number!');
            }

            if (!preg_match("#[a-zA-Z]+#", $request->input('password'))) {
                return response()->json('Password must include at least one letter!');
            }     

            //če gre vse čez kreiraj uporabnika ter ga dodaj v tabelo
            $user = new User();
            $user->name = $request->input('name');
            $user->surname = $request->input('surname');
            $user->username = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->email = $request->input('email');
            //nastavimo da je uporabnik študent
            $user->fk_user_role = 4;
            $user->save();

            //$user = User::create($request->all());
     
            return response()->json($user);

        }
        
        return  response()->json("Missing form data.");
       
       
    }
    

   
}
?>
