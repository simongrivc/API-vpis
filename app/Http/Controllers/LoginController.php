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

        $user = User::select('select * from users where username = ' . $username . ' and password = ' . $password, [1]);
        return response()->json($user);
    }
}
?>
