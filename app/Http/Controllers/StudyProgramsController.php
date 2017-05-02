<?php
 
namespace App\Http\Controllers;
 
use App\StudyProgram;
use App\StudyProgramCallView;
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
            return response()->json($studyProgramCalls);
        }
        //$studyProgramCalls = DB::select("SELECT * FROM study_programs_calls_view");

        return [];
    }
    


}
?>
