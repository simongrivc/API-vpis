<?php
 
namespace App\Http\Controllers;

use App\User;
use App\Application_view;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class ApplicationsController extends Controller{

    public function getApplications(){
 		$user = Auth::user();
 		if($user->fk_user_role==2)
 		{
 			//Vrni vse prijavnice služba vpis
 			//$application = Application_view::all();
 			$applicationsWish1 = Application_view::where('study_programs_calls_wish1_id', '!=', null)->get();
 			$applicationsWish2 = Application_view::where('study_programs_calls_wish2_id', '!=', null)->get();
 			$applicationsWish3 = Application_view::where('study_programs_calls_wish3_id', '!=', null)->get();
        	
        	foreach ($applicationsWish1 as $application) {
	        		$application->study_programs_calls_wish2_id=null;
					$application->study_programs_wish2_is_active=null;			
					$application->study_programs_wish2_id=null;
					$application->study_programs_wish2_program_name=null;
					$application->study_programs_calls_wish2_double_id=null;	
					$application->study_programs_wish2_double_is_active=null;			
					$application->study_programs_wish2_double_id=null;
					$application->study_programs_wish2_double_program_name=null;		
					$application->study_programs_calls_wish3_id=null;	
					$application->study_programs_wish3_is_active=null;			
					$application->study_programs_wish3_id=null;
					$application->study_programs_wish3_program_name=null;	
					$application->study_programs_calls_wish3_double_id=null;		
					$application->study_programs_wish3_double_is_active=null;	
					$application->study_programs_wish3_double_id=null;
					$application->study_programs_wish3_double_program_name=null;
        	}

        	foreach ($applicationsWish2 as $application) {
	        		$application->study_programs_calls_wish1_id=null;
					$application->study_programs_wish1_is_active=null;			
					$application->study_programs_wish1_id=null;
					$application->study_programs_wish1_program_name=null;
					$application->study_programs_calls_wish1_double_id=null;	
					$application->study_programs_wish1_double_is_active=null;			
					$application->study_programs_wish1_double_id=null;
					$application->study_programs_wish1_double_program_name=null;		
					$application->study_programs_calls_wish3_id=null;	
					$application->study_programs_wish3_is_active=null;			
					$application->study_programs_wish3_id=null;
					$application->study_programs_wish3_program_name=null;	
					$application->study_programs_calls_wish3_double_id=null;		
					$application->study_programs_wish3_double_is_active=null;	
					$application->study_programs_wish3_double_id=null;
					$application->study_programs_wish3_double_program_name=null;
        	}

        	foreach ($applicationsWish3 as $application) {
	        		$application->study_programs_calls_wish1_id=null;
					$application->study_programs_wish1_is_active=null;			
					$application->study_programs_wish1_id=null;
					$application->study_programs_wish1_program_name=null;
					$application->study_programs_calls_wish1_double_id=null;	
					$application->study_programs_wish1_double_is_active=null;			
					$application->study_programs_wish1_double_id=null;
					$application->study_programs_wish1_double_program_name=null;		
					$application->study_programs_calls_wish2_id=null;	
					$application->study_programs_wish2_is_active=null;			
					$application->study_programs_wish2_id=null;
					$application->study_programs_wish2_program_name=null;	
					$application->study_programs_calls_wish2_double_id=null;		
					$application->study_programs_wish2_double_is_active=null;	
					$application->study_programs_wish2_double_id=null;
					$application->study_programs_wish2_double_program_name=null;
        	}


        	return response()->json(array_merge($applicationsWish1, $applicationsWish2,  $applicationsWish3));
 		}
 		else if($user->fk_id_vis_institution!=null && $user->fk_user_role==3)
 		{
 			//prefiltriraj prijavnice glede na id fakultete referenta
 			$idFakulteta = $user->fk_id_vis_institution;
 			$applicationsWish1 = DB::table('applications_view')
								    ->where('study_programs_calls_wish1_id', '!=', null)
								    ->where('program_carrier_wish1_id', '=', $idFakulteta)
								    ->get();

        	return response()->json($applicationsWish1);
 		}
 		else
 			return false;
    }
    


}
?>
