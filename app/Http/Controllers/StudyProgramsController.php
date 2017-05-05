<?php
 
namespace App\Http\Controllers;
 
use App\StudyProgram;
use App\StudyProgramCallView;
use App\StudyProgramCall;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class StudyProgramsController extends Controller{

    public function index(){
 
        $studyPrograms = StudyProgram::all();
        return response()->json($studyPrograms);
    }
 
    public function getStudyProgramById(Request $request, $id){

        $studyProgram = StudyProgram::find($id);

        return response()->json($studyProgram);
    }

    public function getStudyProgramCallsActive(Request $request){
        
        $studyProgramCalls = StudyProgramCallView::where('is_active', '!=', 0)->get();
        if($studyProgramCalls)
        {
          foreach ($studyProgramCalls as $program) {
            $program->nr_slo_eu_vpis_mock =0;
            $program->nr_foreigners_vpis_mock =0;
            $program->nr_without_citizenship_vpis_mock =0;
            $program->nr_slo_eu_sprejeti_mock =0;
            $program->nr_foreigners_sprejeti_mock =0;
            $program->nr_without_citizenship_sprejeti_mock =0;
          }
          return response()->json($studyProgramCalls);
        }
        //$studyProgramCalls = DB::select("SELECT * FROM study_programs_calls_view");

        return response()->json([]);
    }
    
    //dobi vse razpisane programe na posameznem razpisu
     public function getStudyProgramCallsActiveFromGroup(Request $request, $id){
        if($id>0)
        {
          //$studyProgramCalls = StudyProgramCallView::where('is_active', '!=', 0)->get();
          $studyProgramCalls = DB::table('study_programs_calls_view')
                      ->where('is_active', '!=', 0)
                      ->where('fk_id_call_group', '=', $id)
                      ->get();
          if($studyProgramCalls)
          {
            foreach ($studyProgramCalls as $program) {
              $program->nr_slo_eu_vpis_mock =0;
              $program->nr_foreigners_vpis_mock =0;
              $program->nr_without_citizenship_vpis_mock =0;
              $program->nr_slo_eu_sprejeti_mock =0;
              $program->nr_foreigners_sprejeti_mock =0;
              $program->nr_without_citizenship_sprejeti_mock =0;
            }
            return response()->json($studyProgramCalls);
          }
          //$studyProgramCalls = DB::select("SELECT * FROM study_programs_calls_view");

         return response()->json([]);

        }
        else
            return response()->json(array('error' => 'Wrong call group id.'),400);
        
    }

    public function deleteStudyProgramCallById(Request $request){
        $id=$request->input('id');
        if($id)
        {
          $studyProgramCall= StudyProgramCall::find($id);
          if($studyProgramCall){
            $studyProgramCall->is_active=0;
            $studyProgramCall->save();
            return response()->json(array('success' => 'Program call deleted successfully'));
          }
          else
            return response()->json(array('error' => 'No program call with that id.'),400);
        }
        else
           return response()->json(array('error' => 'Wrong or missing id data.'),400);
    }
    
    public function addStudyProgramCallById(Request $request){
        $fk_id_call_type=$request->input('fk_id_call_type');
        $nr_slo_eu=$request->input('nr_slo_eu');
        $nr_without_citizenship_foreigners=$request->input('nr_without_citizenship_foreigners');
        $fk_id_study_program=$request->input('fk_id_study_program');
        $min_nr_points=$request->input('min_nr_points');
        $fk_id_call_group=$request->input('fk_id_call_group');

        if($fk_id_call_type>0 && $nr_slo_eu>=0 &&  $nr_without_citizenship_foreigners>=0 && $fk_id_study_program>0 && $min_nr_points>=0 && $fk_id_call_group>0)
        {
            
            $ProgramCall= new StudyProgramCall();
            $ProgramCall->fk_id_call_type=$fk_id_call_type;
            $ProgramCall->nr_slo_eu=$nr_slo_eu;
            $ProgramCall->nr_without_citizenship_foreigners=$nr_without_citizenship_foreigners;
            $ProgramCall->fk_id_study_program=$fk_id_study_program;
            $ProgramCall->min_nr_points=$min_nr_points;
            $ProgramCall->fk_id_call_group=$fk_id_call_group;
            $ProgramCall->save();

            return response()->json($ProgramCall);
        }
          else
            return response()->json(array('error' => 'Wrong or missing input data.'),400);
    
    }

}
?>
