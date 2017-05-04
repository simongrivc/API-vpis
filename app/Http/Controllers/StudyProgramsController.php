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
     public function getStudyProgramCallsActiveFromGroup(Request $request){
        $idGroup = $request->input('id');
        if($idGroup)
        {
          //$studyProgramCalls = StudyProgramCallView::where('is_active', '!=', 0)->get();
          $studyProgramCalls = DB::table('study_programs_calls_view')
                      ->where('is_active', '!=', 0)
                      ->where('fk_id_call_group', '=', $idGroup)
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
    


}
?>
