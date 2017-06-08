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
		->join('call_type', 'call_type.id', '=', 'study_programs_calls.fk_id_call_type')
		->join('study_programs', 'study_programs.id', '=', 'study_programs_calls.fk_id_study_program')
		->join('vis_institutions', 'vis_institutions.id', '=', 'study_programs.fk_id_program_carrier')
		->where('is_active', 1)
		->select("study_programs_calls.*", "condition_groups.id AS condition_group_id",
				 "call_type.type_name as call_type_name", "study_programs.program_name", "vis_institutions.institution_name")
		->get();
		
		foreach($program_calls as $program_call){			
			//posamezen razpisan program -> program_call
			
			//vse prijave za posamezen razpisan program
			$applications = DB::table('applications')
			->join('users', 'users.id', '=', 'applications.fk_id_user')
			->orwhere('fk_id_wish1', $program_call->id)
			->orwhere('fk_id_wish2', $program_call->id)
			->orwhere('fk_id_wish3', $program_call->id)
			->select('applications.*', 'users.name', 'users.surname')
			->get();
			
			//vsi pogoji za razpisan program z utežmi
			$conditions = DB::table('program_call_conditions')
			->join('condition_codes', 'condition_codes.id', '=', 'program_call_conditions.fk_condition_code_id')
			->where('fk_condition_group', $program_call->condition_group_id)
			->select('program_call_conditions.*', 'condition_codes.condition_code_name AS fk_condition_code_name', 'condition_codes.RIC_condition_code')
			->get();
			
			
			
			/*echo "Izpis aplikacij za razpis: ".$program_call->id;
			var_dump(count($applications));
			var_dump($applications);
			echo "-------------------------------------------";*/
			
			
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

				
				
				$fulfills = true;
				$itCond = $conditions;
				//preverjanje pogojev
				foreach($itCond as $condition){
					if(!array_key_exists($condition->RIC_condition_code, $RICgradesCheckArray)){
						$fulfills = false;
					}
				}
				
				
				if($fulfills){			
					
					//računanje točk
					//...
					$points = 92;
					if(array_key_exists($application->id."-".$wish, $seznam)){
						$result = $seznam[$application->id."-".$wish];
						
						//če je boljši rezultat potem ga upoštevamo
						if($points > $result->points){
							$seznam[$application->id."-".$wish] = array('emso' => $application->emso, 'name' => $application->name, 'surname' => $application->surname, 'wish' => $wish, 'program' => $program_call->program_name,
							'institution' => $program_call->institution_name, 'call_type' => $program_call->call_type_name, 'points' => $points, 'fulfills' => true);
						}
						
					}
					else{
						$seznam[$application->id."-".$wish] = array('emso' => $application->emso, 'name' => $application->name, 'surname' => $application->surname, 'wish' => $wish, 'program' => $program_call->program_name,
						  'institution' => $program_call->institution_name, 'call_type' => $program_call->call_type_name, 'points' => $points, 'fulfills' => true);
					}					
					
				}
				else{
					//kandidat ne ustreza pogojem
					$seznam[$application->id."-".$wish] = array('emso' => $application->emso, 'name' => $application->name, 'surname' => $application->surname, 'wish' => $wish, 'program' => $program_call->program_name,
						  'institution' => $program_call->institution_name, 'call_type' => $program_call->call_type_name, 'points' => 0, 'fulfills' => false);
				}				
			}
			
		}
		
		$seznamF = array();
		
		foreach($seznam as $key => $value){
			$seznamF[] = $value;
		}
		
		//shraniš kandidate(emso) in rezultat v tabelo z rezultati
		
		return response()->json($seznamF);						
	}
}
?>
