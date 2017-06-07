<?php
 
namespace App\Http\Controllers;
 
use App\StudyProgram;
use App\StudyProgramCallView;
use App\StudyProgramCall;
use App\Application_view;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class PointsCalculator extends Controller{

    public function index(){
 
        /*$studyPrograms = StudyProgram::all();
        return response()->json($studyPrograms);*/
    }
	
	public function calculate(Request $request){
		
		//sprehodiš se čez vse razpisane programe
		
		$program_calls = DB::table('study_programs_calls')
		->join('condition_groups', 'fk_program_call_id', '=', 'study_programs_calls.id')
		->where('is_active', 1)
		->get();
		
		foreach($program_calls as $program_call){
			var_dump($program_call);
		}
		
		//iz baze vzameš vse kandidate, ki so se prijavili na to šifro, preveriš da imamo podatke iz RIC-a
		//iz baze vzameš pravilo za condition group
		
		//od vsakega kandidata vzameš rezultate ric_grade
		//poračunaš koliko točk je dosegel
		
		//shraniš kandidata(emso) in rezultat v tabelo z rezultati
		
		//kandidati splošna matura
		
					
						
	}
}
?>
