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
    
    public function getFaculties(Request $request){
        $institutions = DB::select("SELECT inst.id, inst.institution_name AS name, inst.abbreviation,
                                   m.id AS id_municipality, m.municipality_name, u.id AS id_university,
                                   u.university_name
                                   FROM vis_institutions inst
                                   INNER JOIN municipalities m ON inst.fk.id_minucipality = m.id
                                   INNER JOIN universities u ON inst.fk_id_university = u.id");
        
        return response()->json($institutions);
    }

}
?>
