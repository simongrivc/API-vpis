<?php
 
namespace App\Http\Controllers;
 
use App\StudyProgram;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class VisInstitutionsController extends Controller{

    public function index(){        
        $institutions = DB::select("SELECT inst.id, inst.institution_name AS name, inst.abbreviation,
                                   m.id AS id_municipality, m.municipality_name, u.id AS id_university,
                                   u.university_name
                                   FROM vis_institutions inst
                                   INNER JOIN municipalities m ON inst.fk_id_municipality = m.id
                                   INNER JOIN universities u ON inst.fk_id_university = u.id");
        
        return response()->json($institutions);
    }
    
    public function getVisByUniversity(Request $request){
        $university = "";
        
        if($request->input('id_university') || $request->input('id_university') == 0){
            $university = " WHERE u.id = ".$request->input('id_university');
        }
        
        $institutions = DB::select("SELECT inst.id, inst.institution_name AS name, inst.abbreviation,
                                   m.id AS id_municipality, m.municipality_name, u.id AS id_university,
                                   u.university_name
                                   FROM vis_institutions inst
                                   INNER JOIN municipalities m ON inst.fk_id_municipality = m.id
                                   INNER JOIN universities u ON inst.fk_id_university = u.id".$university);
        
        return response()->json($institutions);
    }
 
 

}
?>
