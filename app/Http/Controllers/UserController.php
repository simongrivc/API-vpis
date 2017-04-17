<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class UserController extends Controller{

    public function createUser(Request $request){
 
        $user = User::create($request->all());
 
        return response()->json($user);
 
    }
 
    public function editUser(Request $request, $id){

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->save();
 
        return response()->json($user);
    }  

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
 
        return response()->json('User successfully deleted.');
    }
    
    public function activateUser(Request $request){
        if($request->input('activation_code')){
            $user = User::where('activation_code', '=', $request->input('activation_code'));
            if($user){
                $user->is_active = 1;
                $user->save();
                return response()->json(array('status' => 'activated'));
            }
            return response()->json(array('status' => 'not_found'));            
        }
        
        return  response()->json(array('error' => 'missing_data'), 400);
        
    }

}
?>
