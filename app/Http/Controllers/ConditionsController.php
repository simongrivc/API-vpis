<?php
 
namespace App\Http\Controllers;
 
use App\ProgramCallCondition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class ConditionsController extends Controller{

    public function index(){
 
        $condition = ProgramCallCondition::all();
        return response()->json($condition);
    }
    
    public function addCondition(Request $request){

        if($request->input('program_call_id') && $request->input('condition_code_id') && ($request->input('condition_weight') || $request->input('condition_weight') == 0 && $request->input('condition_weight') != "") && ($request->input('must_have') || $request->input('must_have') == 0 && $request->input('must_have') != ""))
        {            
            $id = DB::table('program_call_conditions')->insertGetId(
                ['must_have' => $request->input('must_have'), 'condition_weight' => $request->input('condition_weight'), 'fk_condition_code_id' => $request->input('condition_code_id'), 'fk_program_call_id' =>  $request->input('program_call_id')]
            );
            return response()->json(array('success' => 'condition_added'));
        }
        return  response()->json(array('error' => 'missing_data'), 400);
    }
    
    public function deleteCondition(Request $request){
        if($request->input('condition_id'))
        {
            $cond = ProgramCallCondition::find($request->input('condition_id'));
            $cond->delete();
            return response()->json(array('success' => 'condition_deleted'));
        }
        return  response()->json(array('error' => 'missing_data'), 400);
    }
    
    public function updateCondition(Request $request){    
        if($request->input('program_call_id') && $request->input('condition_code_id') && ($request->input('condition_weight') || $request->input('condition_weight') == 0 && $request->input('condition_weight') != "") && ($request->input('must_have') || $request->input('must_have') == 0 && $request->input('must_have') != ""))
        {
            $cond = ProgramCallCondition::find($request->input('condition_id'));
            $cond->must_have = $request->input('name');
            $cond->condition_weight = $request->input('condition_weight');
            $cond->fk_condition_code_id = $request->input('fk_condition_code_id');
            $cond->fk_program_call_id = $request->input('fk_program_call_id');
            $cond->save();
            return response()->json(array('success' => 'condition_updated'));
        }
        return  response()->json(array('error' => 'missing_data'), 400);
    }
    
    public function getProgramCallConditions(Request $request, $id){
        if($id>0)
        {
          $programCallConditions = DB::table('program_call_conditions')
                      ->where('fk_program_call_id', '=', $id)
                      ->get();
          if($programCallConditions)
          {
            return response()->json($programCallConditions);
          }
          else{
            return response()->json([]);
          }
        }
        else
            return response()->json(array('error' => 'input_id_error'),400);
    }
}
?>
