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
		$seznam = array();
		/*$seznam[] = array('emso' => '0123456789', 'name' => 'Luka', 'surname' => 'Novak', 'wish' => 1, 'program' => 'Visokošolski VS',
						  'institution' => 'Fakulteta za računalništvo in informatiko, UL', 'call_type' => 'IZREDNI', 'points' => 92, 'fulfills' => true);
		$seznam[] = array('emso' => '0434345345', 'name' => 'Jaka', 'surname' => 'Klancar', 'wish' => 3, 'program' => 'Univerzitetni UN',
						'institution' => 'Fakulteta za računalništvo in informatiko, UL', 'call_type' => 'REDNI', 'points' => 73, 'fulfills' => false);

		return response()->json($seznam);*/
		
		//izpis vseh aktivnih razpisanih programov
		$program_calls = DB::table('study_programs_calls')		
		->join('condition_groups', 'fk_program_call_id', '=', 'study_programs_calls.id')
		->where('is_active', 1)
		->select("study_programs_calls.*", "condition_groups.id AS condition_group_id")
		->get();
		
		foreach($program_calls as $program_call){			
			//posamezen razpisan program -> program_call
			
			//vse prijave za posamezen razpisan program
			$applications = DB::table('applications')		
			->where('fk_id_wish1', $program_call->id)
			->orwhere('fk_id_wish2', $program_call->id)
			->orwhere('fk_id_wish3', $program_call->id)
			->get();
			
			//vsi pogoji za razpisan program z utežmi
			$conditions = DB::table('program_call_conditions')
			->join('condition_codes', 'condition_codes.id', '=', 'program_call_conditions.fk_condition_code_id')
			->where('fk_condition_group', $program_call->condition_group_id)
			->select('program_call_conditions.*', 'condition_codes.condition_code_name AS fk_condition_code_name', 'condition_codes.RIC_condition_code')
			->get();
			
			
			foreach($applications as $application){
				//posamezna prijava na razpisan program
				$wish = 0;
				
				//določanje katera želja je za razpisan program
				if($application->fk_id_wish1 == $program_call->id){
					$wish = 1;
				} else if($application->fk_id_wish2 == $program_call->id){
					$wish = 2;
				} else if($application->fk_id_wish3 == $program_call->id){
					$wish = 3;
				}
				
				//pridobivanje RIC podatkov kandidata				
				$RICcandidate = DB::table('ric_candidates')				
				->where('emso', $application->emso)				
				->first();
				
				//pridobivanje vseh ocen(iz mature) kandidata
				$RICgrades = DB::table('ric_grades')
				->where('emso', $application->emso)
				->get();
				
				$RICgradesCheckArray = array();
				foreach($RICgrades as $RICgrade){
					$RICgradesCheckArray[] = $RICgrade->fk_subject;
				}
				
				echo "emso: ";
				var_dump($application);
				
				echo "conditions: ";
				var_dump($conditions);
				
				echo "RIC grades: ";
				var_dump($RICgrades);
				
				echo $program_call->fk_id_call_type;
				
				
				$fulfills = true;
				$itCond = $conditions;
				//preverjanje pogojev
				foreach($itCond as $condition){
					if(!array_key_exists($condition->RIC_condition_code, $RICgradesCheckArray)){
						$fulfills = false;
					}
				}
				
				echo "conditions: ";
				var_dump($conditions);
				die();
				
				if($fulfills){
					echo "emso: ";
					var_dump($application);
					
					echo "conditions: ";
					var_dump($conditions);
					
					echo "RIC grades: ";
					var_dump($RICgrades);
					
					echo $program_call->fk_id_call_type;
					
					//računanje točk
					//...
					$seznam[] = array('emso' => $application->emso, 'name' => 'Luka', 'surname' => 'Novak', 'wish' => 1, 'program' => 'Visokošolski VS',
						  'institution' => 'Fakulteta za računalništvo in informatiko, UL', 'call_type' => 'IZREDNI', 'points' => 92, 'fulfills' => true);
					
				}
				else{
					//kandidat ne ustreza pogojem
					
				}				
			}
			
		}
		
		var_dump($seznam);
		
		//iz baze vzameš vse kandidate, ki so se prijavili na to šifro, preveriš da imamo podatke iz RIC-a
		//iz baze vzameš pravilo za condition group
		
		//od vsakega kandidata vzameš rezultate ric_grade
		//poračunaš koliko točk je dosegel
		
		//shraniš kandidata(emso) in rezultat v tabelo z rezultati
		
		//kandidati splošna matura
		
					
						
	}
}
?>
