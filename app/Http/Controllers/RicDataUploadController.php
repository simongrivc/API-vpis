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
					
					
					if(!$emso || !$ime || !$priimek || !$uspeh || !$opravil || !$uspeh3l || !$uspeh4l || !$tip || !$srSola || !$poklic){
						return  response()->json(array('error' => 'file_format_error'), 400);
					}
					
					if($tip != 5){ //kandidat tipa 5 opravlja samo dodaten predmet
						if($uspeh < 0 || $uspeh > 34){
							continue;
						}
						
						if($uspeh3l < 2 || $uspeh3l > 5){
							continue;
						}
						
						if($uspeh4l < 2 || $uspeh4l > 5){
							continue;
						}
					}
					
					if($opravil != "D" || $opravil != "N"){
						continue;
					}
					
					$school = DB::table('middle_schools')->where('id', $srSola)->first();
					if(!$school){
						continue;
					}
					
					$profession = DB::table('gained_professions')->where('id', $poklic)->first();
					if(!$profession){
						continue;
					}
					
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
					
					$user = DB::table('applications')->where('emso', $emso)->first();
					if($user){
						//obstaja prijava za tale emso, vpišemo zaključno oceno in poklic
						$id = DB::table('ric_candidates')->insertGetId(
							['emso' => $emso, 'fk_profession' => $poklic, 'points_grade' => $uspeh, 'success' => $opravil, 'grade3' => $uspeh3l, 'grade4' => $uspeh4l,
							 'fk_type' => $tip, 'fk_middle_school' => $srSola]
						);
					}
				}
				return response()->json(array('success' => 'candidates_added'));
			} catch(Exception $e){
				 return  response()->json(array('error' => 'file_format_error'), 400);
			}
		}
		
		//rezultati splošne mature
		if ($request->hasFile('maturpre')) {			
			
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
						
						//veljavna šifra predmeta
						$predmet = DB::table('condition_codes')->where('id', $id_predmet)->first();
						if(!$predmet){
							continue;
						}
						
						if($user->fk_type != 5){
							//kandidat tipa 5 opravlja samo dodaten predmet, zato nima vpisanih ocen
							
							if($ocena < 1 || $ocena > 5){
								continue;
							}
							
							if($ocena3l < 2 || $ocena3l > 5){
								continue;
							}
							
							if($ocena4l < 2 || $ocena4l > 5){
								continue;
							}							
						}
						
						if($opravil != "D" || $opravil != "N"){
							continue;
						}
						
						$school = DB::table('middle_schools')->where('id', $srSola)->first();
						if(!$school){
							continue;
						}
							
						$profession = DB::table('gained_professions')->where('id', $poklic)->first();
						if(!$profession){
							continue;
						}
						
						/*$type_subj = DB::table('type_subject')->where('id', $tip_predmeta)->first();
						if(!$type_subj){
							continue;
						}*/
						$new = 0;
						$updated = 0;
						
						if($user->fk_type == 0 || $user->fk_type == 1 || $user->fk_type == 2){
							//vpisovanje novih podatkov
							$id = DB::table('ric_grades')->insertGetId(
								['emso' => $emso, 'fk_subject' => $id_predmet, 'grade' => $ocena, 'grade3' => $ocena3l, 'grade4' => $ocena4l,
								 'success' => $opravil, 'fk_type_subject' => $tip_predmeta]
							);
							$new++;
						}
						else if($user->fk_type == 3 || $user->fk_type == 4){
							//posodabljanje podatkov							
							DB::table('ric_grades')
							->where('emso', $emso)
							->where('fk_subject', $id_predmet)
							->update(['grade' => $ocena, 'grade3' => $ocena3l, 'grade4' => $ocena4l, 'success' => $opravil, 'fk_type_subject' => $id_predmet]);
							$updated++;
						}
						
					}
				}
				return response()->json(array('success' => 'results_added', 'added' => $new, 'updated' => $updated));
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
						$id = DB::table('ric_candidates')->insertGetId(
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
						$id = DB::table('ric_grades')->insertGetId(
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
