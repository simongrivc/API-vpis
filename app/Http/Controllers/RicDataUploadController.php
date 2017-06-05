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
 
class RicDataUploadController extends Controller{

    public function index(){
 
        $studyPrograms = StudyProgram::all();
        return response()->json($studyPrograms);
    }
	
	public function uploadFile(Request $request){
		
		//kandidati splošna matura
		if ($request->hasFile('maturant')) {
			
			$persons = array();
			$errors = 0;
			
			if (!$request->file('maturant')->isValid()) {
				 return  response()->json(array('error' => 'file_not_valid'), 400);
			}
			
			if ($request->file('maturant')->getClientOriginalExtension() != "txt"){
				 return  response()->json(array('error' => 'wrong_fileType'), 400);
			}
			
			if ($request->file('maturant')->getMimeType() != "text/plain"){
				 return  response()->json(array('error' => 'wrong_mimeType'), 400);
			}
			
			try {	
				$txt_file    = file_get_contents($request->file('maturant'));
				$txt_file = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $txt_file);
				$rows        = explode("\n", $txt_file);
				//array_shift($rows);
				
				foreach($rows as $row => $data)
				{
					
					$error = false;
					$row_data = explode('Q', $data);
					
					$emso = $row_data[0];
					$ime = $row_data[1];
					$priimek = $row_data[2];
					$uspeh = $row_data[3];
					$opravil = str_replace(' ', '', $row_data[4]);
					$uspeh3l = $row_data[5];
					$uspeh4l = $row_data[6];
					$tip = $row_data[7];
					$srSola = $row_data[8];
					$poklic = $row_data[9];
					
					$uspeh = str_replace(' ', '', $uspeh);					
					$uspeh3l = str_replace(' ', '', $uspeh3l);
					$uspeh4l = str_replace(' ', '', $uspeh4l);
					
					if($uspeh == ""){
						$uspeh = 0;
					}
					
					if($uspeh3l == ""){
						$uspeh3l = 0;
					}
					
					if($uspeh4l == ""){
						$uspeh4l = 0;
					}
					
					
					if(!$emso || !$ime || !$priimek || !$tip || !$srSola || !$poklic){
						return  response()->json(array('error' => 'file_format_error'), 400);
					}					
					
					if($tip != 5){
						if(!$uspeh || !$uspeh3l || !$uspeh4l ){
							$error = true;
						}
						//kandidat tipa 5 opravlja samo dodaten predmet
						if($uspeh < 0 || $uspeh > 34){
							$error = true;
						}
						
						if($uspeh3l < 2 || $uspeh3l > 5){
							$error = true;
						}
						
						if($uspeh4l < 2 || $uspeh4l > 5){
							$error = true;
						}
						/*if($opravil != "D" || $opravil != "N"){
							$error = true;
						}*/
					}
					
					
					/*$school = DB::table('middle_schools')->where('id', $srSola)->first();
					if(!$school){
						$error = true;
					}
					
					$profession = DB::table('gained_professions')->where('id', $poklic)->first();
					if(!$profession){
						$error = true;
					}*/
					
					/*$info[$row]['emso']      = $emso;
					$info[$row]['ime']       = $ime;
					$info[$row]['priimek']   = $priimek;
					$info[$row]['uspeh']     = $uspeh;
					$info[$row]['opravil']   = $opravil;
					$info[$row]['uspeh3l']   = $uspeh3l;
					$info[$row]['uspeh4l']   = $uspeh4l;
					$info[$row]['tip']       = $tip;
					$info[$row]['srSola']    = $srSola;
					$info[$row]['poklic']    = $poklic;*/
					
					if(!$error){
						$user = DB::table('applications')->where('emso', $emso)->first();
						$RicUser = DB::table('ric_candidates')->where('emso', $emso)->where('fk_profession', $poklic)->first();
						//if($user){ testiranje če je prijava za tega userja
						if(!$RicUser){
							//obstaja prijava za tale emso, vpišemo zaključno oceno in poklic
							$id = DB::table('ric_candidates')->insert(
								['emso' => $emso, 'fk_profession' => $poklic, 'points_grade' => $uspeh, 'success' => $opravil, 'grade3' => $uspeh3l, 'grade4' => $uspeh4l,
								 'fk_type' => $tip, 'fk_middle_school' => $srSola, 'name' => $ime, 'surname' => $priimek]
							);
						}
					}
					else{
						$errors++;
						$persons[] = array('emso' => $emso, 'name' => $ime, 'surname' => $priimek);
					}
					
				}
				return response()->json(array('success' => 'candidates_added', 'error_persons' => $persons));
			} catch(Exception $e){
				 return  response()->json(array('error' => 'file_format_error'), 400);
			}
		}
		
		//rezultati splošne mature
		if ($request->hasFile('maturpre')) {			
			
			$new = 0;
			$updated = 0;
			$errors = 0;
			$persons = array();
			
			if (!$request->file('maturpre')->isValid()) {
				 return  response()->json(array('error' => 'file_not_valid'), 400);
			}
				
			if ($request->file('maturpre')->getClientOriginalExtension() != "txt"){
				 return  response()->json(array('error' => 'wrong_fileType'), 400);
			}
			
			if ($request->file('maturpre')->getMimeType() != "text/plain"){
				 return  response()->json(array('error' => 'wrong_mimeType'), 400);
			}
			
			try {	
				$txt_file    = file_get_contents($request->file('maturpre'));
				$rows        = explode("\n", $txt_file);
				//array_shift($rows);
				
				foreach($rows as $row => $data)
				{
					
					$error = false;
					$row_data = explode('Q', $data);
					//var_dump($row_data);
					$emso = $row_data[0];
					$id_predmet = $row_data[1];
					$ocena = $row_data[2];
					$ocena3l = $row_data[3];
					$ocena4l = $row_data[4];
					$opravil = $row_data[5];
					$tip_predmeta = str_replace(' ', '', $row_data[6]);
					
					if(!$emso || !$id_predmet || !$ocena || !$ocena3l || !$ocena4l || !$opravil || !$tip_predmeta ||
					   $emso == "" || $id_predmet == "" || $ocena == "" || $ocena3l == "" || $ocena4l == "" || $opravil == "" || $tip_predmeta == ""){
						return response()->json(array('error' => 'file_format_error'), 400);
					}
														
					$user = DB::table('ric_candidates')->where('emso', $emso)->first();
					if($user){
						//obstaja prijava za tale emso, vpišemo zaključno oceno in poklic
						
						//veljavna šifra predmeta
						/*$predmet = DB::table('condition_codes')->where('id', $id_predmet)->first();
						if(!$predmet){
							$error = true;
						}*/
						
						if($user->fk_type != 5){
							//kandidat tipa 5 opravlja samo dodaten predmet, zato nima vpisanih ocen
							
							if($ocena < 1 || $ocena > 5){
								$error = true;
							}
							
							if($ocena3l < 2 || $ocena3l > 5){
								$error = true;
							}
							
							if($ocena4l < 2 || $ocena4l > 5){
								$error = true;
							}							
						}
						
						if($opravil != "D" || $opravil != "N"){
							$error = true;
						}
						
						/*$school = DB::table('middle_schools')->where('id', $srSola)->first();
						if(!$school){
							$error = true;
						}
							
						$profession = DB::table('gained_professions')->where('id', $poklic)->first();
						if(!$profession){
							$error = true;
						}*/
						
						/*$type_subj = DB::table('type_subject')->where('id', $tip_predmeta)->first();
						if(!$type_subj){
							continue;
						}*/
						
						if(!$error){
							if($user->fk_type == 0 || $user->fk_type == 1 || $user->fk_type == 2){
								//vpisovanje novih podatkov
								$id = DB::table('ric_grades')->insert(
									['emso' => $emso, 'fk_subject' => $id_predmet, 'grade' => $ocena, 'grade3' => $ocena3l, 'grade4' => $ocena4l,
									 'success' => $opravil, 'fk_type_subject' => $tip_predmeta]
								);
								$new++;
							}
							else if($user->fk_type == 3 || $user->fk_type == 4){
								//posodabljanje podatkov							
								$id = DB::table('ric_grades')
								->where('emso', $emso)
								->where('fk_subject', $id_predmet)
								->update(['grade' => $ocena, 'grade3' => $ocena3l, 'grade4' => $ocena4l, 'success' => $opravil, 'fk_type_subject' => $id_predmet]);
								$updated++;
							}
						}
						else{
							$errors++;
							/*$upor = DB::table('applications')->where('emso', $emso)->first();
							$user = DB::table('users')->where('id', $upor->fk_id_user)->first();*/
							
							$persons[] = array('emso' => $user->emso, 'name' => $user->name, 'surname' => $user->surname);
						}
						
					}
					else{
						$errors++;
						/*$upor = DB::table('applications')->where('emso', $emso)->first();
						$user = DB::table('users')->where('id', $upor->fk_id_user)->first();*/
						
						$persons[] = array('emso' => $emso, 'name' => "---", 'surname' => "---");
					}
				}
				return response()->json(array('success' => 'results_added', 'added' => $new, 'updated' => $updated, 'errors' => $errors, 'error_persons' => $persons));
			} catch(Exception $e){
				 return  response()->json(array('error' => 'file_format_error'), 400);
			}
		}
		
		
		//kandidati poklicna matura
		if ($request->hasFile('poklmat')) {			
			
			if (!$request->file('poklmat')->isValid()) {
				 return  response()->json(array('error' => 'file_not_valid'), 400);
			}
				
			if ($request->file('poklmat')->getClientOriginalExtension() != "txt"){
				 return  response()->json(array('error' => 'wrong_fileType'), 400);
			}
			
			if ($request->file('poklmat')->getMimeType() != "text/plain"){
				 return  response()->json(array('error' => 'wrong_mimeType'), 400);
			}
			
			try {	
				$txt_file    = file_get_contents($request->file('poklmat'));
				$rows        = explode("\n", $txt_file);
				array_shift($rows);
				
				foreach($rows as $row => $data)
				{
					$row_data = explode('Q', $data);
					
					$emso = $row_data[0];
					$ime = $row_data[1];
					$priimek = $row_data[2];
					$uspeh = $row_data[3];
					$opravil = $row_data[4];
					$uspeh3l = $row_data[5];
					$uspeh4l = $row_data[6];
					$tip = $row_data[7];
					$srSola = $row_data[8];
					$poklic = $row_data[9];
					$maximum = $row_data[10];
					
					if(!$emso || !$ime || !$priimek || !$uspeh || !$opravil || !$uspeh3l || !$uspeh4l || !$tip || !$srSola || !$poklic || !$maximum){
						return  response()->json(array('error' => 'file_format_error'), 400);
					}
					
					$user = DB::table('applications')->where('emso', $emso)->first();
					if($user){
						//obstaja prijava za tale emso, vpišemo zaključno oceno in poklic
						$id = DB::table('ric_candidates')->insert(
							['emso' => $emso, 'fk_profession' => $poklic, 'points_grade' => $uspeh, 'success' => $opravil, 'grade3' => $uspeh3l, 'grade4' => $uspeh4l,
							 'fk_type' => $tip, 'fk_middle_school' => $srSola, 'maximum' => $maximum]
						);
					}
				}
				return response()->json(array('success' => 'candidates_added'));
			} catch(Exception $e){
				 return  response()->json(array('error' => 'file_format_error'), 400);
			}
		}
		
		
		
		//rezultati poklicne mature				
		if ($request->hasFile('poklpre')) {			
			
			if (!$request->file('poklpre')->isValid()) {
				 return  response()->json(array('error' => 'file_not_valid'), 400);
			}
				
			if ($request->file('poklpre')->getClientOriginalExtension() != "txt"){
				 return  response()->json(array('error' => 'wrong_fileType'), 400);
			}
			
			if ($request->file('poklpre')->getMimeType() != "text/plain"){
				 return  response()->json(array('error' => 'wrong_mimeType'), 400);
			}
			
			try {	
				$txt_file    = file_get_contents($request->file('poklpre'));
				$rows        = explode("\n", $txt_file);
				array_shift($rows);
				
				foreach($rows as $row => $data)
				{
					$row_data = explode('Q', $data);
					
					$emso = $row_data[0];
					$id_predmet = $row_data[1];
					$ocena = $row_data[2];
					$ocena3l = $row_data[3];
					$ocena4l = $row_data[4];
					$opravil = $row_data[5];
					$tip_predmeta = $row_data[6];
					
					if(!$emso || !$id_predmet || !$ocena || !$ocena3l || !$ocena4l || !$opravil || !$tip_predmeta){
						return response()->json(array('error' => 'file_format_error'), 400);
					}
														
					$user = DB::table('ric_candidates')->where('emso', $emso)->first();
					if($user){
						//obstaja prijava za tale emso, vpišemo zaključno oceno in poklic
						$id = DB::table('ric_grades')->insert(
							['emso' => $emso, 'fk_subject' => $id_predmet, 'grade' => $ocena, 'grade3' => $ocena3l, 'grade4' => $ocena4l,
							 'success' => $opravil, 'fk_type_subject' => $tip_predmeta]
						);
					}
				}
				return response()->json(array('success' => 'results_added'));
			} catch(Exception $e){
				 return  response()->json(array('error' => 'file_format_error'), 400);
			}
		}		
		
	}
}
?>
