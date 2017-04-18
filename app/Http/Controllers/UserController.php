<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
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
            $idCode = DB::table('user_activations')
                    ->where('activation_code', '=', $request->input('activation_code'))->first();
            
            /*$durationValid = 1; //duration in days
            $durationValidBorder = time() - ($durationValid * 24*60*60);*/
            
            
            $user = User::where('fk_activation_code', '=', $idCode->id)->first();
            
            if($user && $user != null){
                $user->is_active = 1;
                $user->save();
                return response()->json(array('success' => 'activated'));
            }
            return response()->json(array('error' => 'not_found'), 400);            
        }
        
        return  response()->json(array('error' => 'missing_data'), 400);
        
    }
    
    public function activateUserMock(Request $request){
        $code = $request->get('activation_code');
        if($code){
            $idCode = DB::table('user_activations')
                    ->where('activation_code', '=', $request->input('activation_code'))->first();
                    
            /*$durationValid = 1; //duration in days
            $durationValidBorder = time() - ($durationValid * 24*60*60);*/
                    
            $user = User::where('fk_activation_code', '=', $idCode->id)->first();
            

            if($user && $user != null){
                $user->is_active = 1;
                $user->save();
                return response()->json(array('success' => 'activated'));
            }
            return response()->json(array('error' => 'not_found'), 400);            
        }
        
        return  response()->json(array('error' => 'missing_data'), 400);
        
    }

}
?>
