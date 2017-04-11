<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{

  
    public function login(Request $request){
        //dobi podatke o uporabniškem imenu in emailu (vereficiraj)
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where([
                    ['username', '=', 'simongrivc'],
                    ['password', '=', 'simongeslo'],
                ])->first();

        //$user = User::whereName($username)->wherePassword($password)->first();
        return response()->json($user);
    }
}
?>
