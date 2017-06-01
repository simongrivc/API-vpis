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
		
		if ($request->hasFile('maturant')) {
			if ($request->file('maturant')->isValid()) {
				//echo "berem dat";
				var_dump($request->file('maturant')->getClientOriginalExtension());
				var_dump($request->file('maturant')->getMimeType());
				die();
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
					
					$info[$row]['emso']      = $emso;
					$info[$row]['ime']       = $ime;
					$info[$row]['priimek']   = $priimek;
					$info[$row]['uspeh']     = $uspeh;
					$info[$row]['opravil']   = $opravil;
					$info[$row]['uspeh3l']   = $uspeh3l;
					$info[$row]['uspeh4l']   = $uspeh4l;
					$info[$row]['tip']       = $tip;
					$info[$row]['srSola']    = $srSola;
					$info[$row]['poklic']    = $poklic;
					
					$user = DB::table('applications')->where('emso', $info[$row]['emso'])->first();
					if($user){
						//obstaja prijava za tale emso, vpišemo zaključno oceno in poklic
						$id = DB::table('ric_candidates')->insertGetId(
                            ['emso' => $emso, 'fk_profession' => $poklic, 'points_grade' => $uspeh, 'success' => $opravil, 'grade3' => $uspeh3l, 'grade4' => $uspeh4l,
							 'fk_type' => $tip, 'fk_middle_school' => $srSola]
                        );						
						
					}
					
				
					/*echo 'Row ' . $row . ' emso: ' . $info[$row]['emso'] . '<br />';
					echo 'Row ' . $row . ' NAME: ' . $info[$row]['name'] . '<br />';
					echo 'Row ' . $row . ' DESCRIPTION: ' . $info[$row]['description'] . '<br />';
					echo 'Row ' . $row . ' IMAGES:<br />';*/
									
				
					//display images
					/*$row_images = explode(',', $info[$row]['images']);
				
					foreach($row_images as $row_image)
					{
						echo ' - ' . $row_image . '<br />';
					}
					*/
					//echo '<br />';
				}
				//var_dump($info);				
				
			}
			else{
				echo "no valid";
			}
		}
		else{
			echo "no file";
		}
	} 

}
?>
