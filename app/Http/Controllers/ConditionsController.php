<?php
 
namespace App\Http\Controllers;
 
use App\ProgramCallCondition;
use App\ConditionGroup;
use App\AcceptanceTestConditionView;
use App\AcceptanceTestCondition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class ConditionsController extends Controller{

    public function index(){
 
        /*$condition = ProgramCallCondition::all();
        return response()->json($condition);*/
    }
    
    //pri dodajanju je pomemben weight; vmes so lahko pogoji tudi z 0, kar pomeni da je ta predmet obvezen,
    //pri tem ne rabmo must_have
    //seštevek vseh pogojev pa mora bit 0 ali pa 100
    public function addConditionGroup(Request $request){

        if($request->input('program_calls_id') && $request->input('enroll_conds'))
        {            
            //preveri če je weight skupaj == 100% ali pa 0%
            
            foreach ($request->input('enroll_conds') as $pogojGroup) {
                $totalWeight = 0;
                foreach($pogojGroup['conditions'] as $pogoj){
                    $totalWeight += $pogoj["condition_weight"];                    
                }
                
                if($totalWeight != 100 && $totalWeight != 0){
                    //pogoji niso ustrezni
                    return  response()->json(array('error' => 'weight_error'), 400);
                }
                
            }
            
            foreach ($request->input('enroll_conds') as $pogojGroup) {                
                
                //če je groupID manj od 0, potem je to nova grupa, naredi nov vnos
                if($pogojGroup['groupID'] < 0){
                    //kreiraj grupo
                    $groupID = DB::table('condition_groups')->insertGetId(
                        ['fk_program_call_id' => $request->input('program_calls_id')]);
                    
                    //poveži pogoje z grupo
                    foreach ($pogojGroup['conditions']   as $pogoj) {
                        $id = DB::table('program_call_conditions')->insertGetId(
                            ['fk_condition_group' => $groupID, 'condition_weight' => $pogoj["condition_weight"], 'fk_condition_code_id' => $pogoj['condition_code_id']]
                        );
                    }
                }
                else if($pogojGroup['groupID'] >= 0){
                    //posodobi program
                    
                    //izbriši prejšnje pogoje
                    $programCallConditions = DB::table('program_call_conditions')
                      ->where('fk_condition_group', '=', $pogojGroup["groupID"])
                      ->delete();
                    
                    $groupID = $pogojGroup["groupID"];
                    
                    //poveži pogoje z grupo
                    foreach ($pogojGroup['conditions']   as $pogoj) {
                        $id = DB::table('program_call_conditions')->insertGetId(
                            ['fk_condition_group' => $groupID, 'condition_weight' => $pogoj["condition_weight"], 'fk_condition_code_id' => $pogoj['condition_code_id']]
                        );
                    }
                      
                }
                
            }
            
            return response()->json(array('success' => 'conditions_added'));
        }
        return  response()->json(array('error' => 'missing_data'), 400);
    }
    
    public function deleteConditionGroup(Request $request){
        if($request->input('condition_group_id'))
        {
            //zbriši vse pogoje vezane na grupo
            $programCallConditions = DB::table('program_call_conditions')
                      ->where('fk_condition_group', '=', $request->input('condition_group_id'))
                      ->delete();
                      
            //preveri če je ostala še kakša grup za program
            $programCallConditions = DB::table('program_call_conditions')
                      ->where('fk_condition_group', '=', $request->input('condition_group_id'))
                      ->count();
                      
            if($programCallConditions < 1) {
                //nato zbriši še grupo
                $group = ConditionGroup::find($request->input('condition_group_id'));
                $group->delete();
            }       
            
            return response()->json(array('success' => 'conditions_deleted'));
        }
        return  response()->json(array('error' => 'missing_data'), 400);
    }
    
    public function updateConditionGroup(Request $request){    
        if($request->input('condition_group_id') && $request->input('conditions'))
        {
            //najlažja implementacija: zbriši vse pogoje vezane na grupo in jih dodaj na novo
            $cond = ProgramCallCondition::find($request->input('condition_group_id'));
            $cond->delete();
            
            //preveri če je weight skupaj == 100% ali pa 0%
            $totalWeight = 0;
            foreach ($request->input('conditions') as $pogoj) {
                $totalWeight += $pogoj["condition_weight"];
            }
            
            if($totalWeight != 100 && $totalWeight != 0){
                //pogoji niso ustrezni
                return  response()->json(array('error' => 'weight_error'), 400);
            }
            
            //poveži pogoje z grupo
            foreach ($request->input('conditions') as $pogoj) {
                $id = DB::table('program_call_conditions')->insertGetId(
                    ['fk_condition_group' => $request->input('condition_group_id'), 'condition_weight' => $pogoj["condition_weight"], 'fk_condition_code_id' => $pogoj['condition_code_id']]
                );
            }
           
            return response()->json(array('success' => 'conditions_updated'));
        }
        return  response()->json(array('error' => 'missing_data'), 400);
    }
    
    public function getProgramCallConditions(Request $request, $id){
        if($id>0)
        {
            //-->TODO<--
            //naredi view
            //poglej v grupo kje se nahaja program_call_id oz. $id
            //tako dobiš vse id-je od grup, ki so vezane na ta razpisan program
            //potem pa v arrayu izpišeš vse pogoje po grupah
            
            
          /*$programCallConditions = DB::table('program_call_conditions')
                      ->where('fk_program_call_id', '=', $id)
                      ->get();
          if($programCallConditions)
          {
            return response()->json($programCallConditions);
          }
          else{
            return response()->json([]);
          }*/
        }
        else
            return response()->json(array('error' => 'input_id_error'),400);
    }

    public function getAllAcceptanceTestConditions()
    {
         $sprejemniIzpiti = AcceptanceTestConditionView::all();
        return response()->json($sprejemniIzpiti);
    }

    public function addAcceptanceTest(Request $request)
    {
        if($request->input('min_points') && $request->input('max_points') && $request->input('fk_id_program_call_conditions'))
        {   

            $existingAcceptanceTestCondition = acceptanceTestCondition::where('fk_id_program_call_conditions', '=', $request->input('fk_id_program_call_conditions'))->get();
            if(sizeof($existingAcceptanceTestCondition)>0)
            {
                //če že obstaja ga popravimo
                return response()->json(array('error' => 'Potrebno popravit.'),400);
            } 
            else
            {
               //dodamo novega
                $acceptanceTestCondition = AcceptanceTestCondition::create($request->all());
                return response()->json($acceptanceTestCondition);
            }
        }
        else
            return response()->json(array('error' => 'Wrong or missing input data.'),400);
        
    }

    
}
?>
