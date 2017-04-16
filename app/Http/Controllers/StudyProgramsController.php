<?php
 
namespace App\Http\Controllers;
 
use App\StudyPrograms;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class StudyProgramsController extends Controller{

    public function index(){
 
        $studyPrograms = StudyPrograms::create($request->all());
        return response()->json($studyPrograms);
    }
 
    public function getStudyProgramById(Request $request, $id){

        $studyProgram = StudyPrograms::find($id);

        return response()->json($studyProgram);
    }  

}
?>
