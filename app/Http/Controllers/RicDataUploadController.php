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
		var_dump($request);
		if ($request->hasFile('maturant')) {
			if ($request->file('maturant')->isValid()) {
				echo "berem dat";
				$txt_file    = file_get_contents($request->file('maturant'));
				$rows        = explode("\n", $txt_file);
				array_shift($rows);
				
				foreach($rows as $row => $data)
				{
					$row_data = explode('Q', $data);
				
					$info[$row]['emso']           = $row_data[0];
					$info[$row]['ime']         = $row_data[1];
					$info[$row]['priimek']  = $row_data[2];
					$info[$row]['uspeh']       = $row_data[3];
				
					echo 'Row ' . $row . ' emso: ' . $info[$row]['emso'] . '<br />';
					/*
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
					echo '<br />';
				}
				echo "end";
				
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
