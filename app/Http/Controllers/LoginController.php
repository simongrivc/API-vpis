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
                    ['username', '=', $username],
                    ['password', '=', $password],
                ])->get()->first();
        return response()->json($user);
    }
}
?>
