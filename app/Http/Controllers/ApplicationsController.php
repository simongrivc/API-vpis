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
 			$application = Application_view::all();
        	return response()->json($application);
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
