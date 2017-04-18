<?php
 
namespace App\Http\Controllers;
 
use App\StudyProgram;
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

    public function getStudyProgramCalls(Request $request){

        $studyProgramCalls = DB::select("SELECT * FROM study_program_view");

        return response()->json($studyProgramCalls);
    }
    


}
?>
