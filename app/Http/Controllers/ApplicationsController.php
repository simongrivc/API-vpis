<?php
 
namespace App\Http\Controllers;

use App\User;
use App\Application_view;
use App\ApplicationModel;
use App\StudyProgramCall;
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

 			$applicationsWish1double = Application_view::where('study_programs_calls_wish1_double_id', '!=', null)->get();
 			$applicationsWish2double = Application_view::where('study_programs_calls_wish2_double_id', '!=', null)->get();
 			$applicationsWish3double = Application_view::where('study_programs_calls_wish3_double_id', '!=', null)->get();

        	$response = [];
        	foreach ($applicationsWish1 as $application) {
        			$studyProgramCallWish = StudyProgramCall::find($application->fk_id_wish1);
        			if($studyProgramCallWish)
        			{
        				if($studyProgramCallWish->is_active==1)
        				{
        					$application->study_programs_calls_wish2_id=null;
			        		$application->study_programs_calls_wish2_call_type=null;
							$application->study_programs_wish2_is_active=null;			
							$application->study_programs_wish2_id=null;
							$application->study_programs_wish2_program_name=null;
							$application->study_programs_calls_wish2_double_id=null;	
							$application->study_programs_wish2_double_is_active=null;			
							$application->study_programs_wish2_double_id=null;
							$application->study_programs_wish2_double_program_name=null;	
							$application->program_carrier_wish2_id=null;
							$application->program_carrier_wish2_institution_name=null;
							$application->study_programs_calls_wish3_id=null;
							$application->study_programs_calls_wish3_call_type=null;
							$application->study_programs_wish3_is_active=null;			
							$application->study_programs_wish3_id=null;
							$application->study_programs_wish3_program_name=null;	
							$application->study_programs_calls_wish3_double_id=null;		
							$application->study_programs_wish3_double_is_active=null;	
							$application->study_programs_wish3_double_id=null;
							$application->study_programs_wish3_double_program_name=null;
							$application->program_carrier_wish3_id=null;
							$application->program_carrier_wish3_institution_name=null;
							array_push($response,$application);
        				}
        			}
        	}

        	foreach ($applicationsWish2 as $application) {
        			$studyProgramCallWish = StudyProgramCall::find($application->fk_id_wish2);
        			if($studyProgramCallWish)
        			{
        				if($studyProgramCallWish->is_active==1)
        				{
			        		$application->study_programs_calls_wish1_id=null;
			        		$application->study_programs_calls_wish1_call_type=null;
							$application->study_programs_wish1_is_active=null;			
							$application->study_programs_wish1_id=null;
							$application->study_programs_wish1_program_name=null;
							$application->study_programs_calls_wish1_double_id=null;	
							$application->study_programs_wish1_double_is_active=null;			
							$application->study_programs_wish1_double_id=null;
							$application->study_programs_wish1_double_program_name=null;
							$application->program_carrier_wish1_id=null;
							$application->program_carrier_wish1_institution_name=null;	
							$application->study_programs_calls_wish3_id=null;
							$application->study_programs_calls_wish3_call_type=null;
							$application->study_programs_wish3_is_active=null;			
							$application->study_programs_wish3_id=null;
							$application->study_programs_wish3_program_name=null;	
							$application->study_programs_calls_wish3_double_id=null;		
							$application->study_programs_wish3_double_is_active=null;	
							$application->study_programs_wish3_double_id=null;
							$application->study_programs_wish3_double_program_name=null;
							$application->program_carrier_wish3_id=null;
							$application->program_carrier_wish3_institution_name=null;
							array_push($response,$application);
						}
					}
        	}

        	foreach ($applicationsWish3 as $application) {
        		$studyProgramCallWish = StudyProgramCall::find($application->fk_id_wish3);
        			if($studyProgramCallWish)
        			{
        				if($studyProgramCallWish->is_active==1)
        				{
			        		$application->study_programs_calls_wish1_id=null;
			        		$application->study_programs_calls_wish1_call_type=null;
							$application->study_programs_wish1_is_active=null;			
							$application->study_programs_wish1_id=null;
							$application->study_programs_wish1_program_name=null;
							$application->study_programs_calls_wish1_double_id=null;	
							$application->study_programs_wish1_double_is_active=null;			
							$application->study_programs_wish1_double_id=null;
							$application->study_programs_wish1_double_program_name=null;
							$application->program_carrier_wish1_id=null;	
							$application->program_carrier_wish1_institution_name=null;
							$application->study_programs_calls_wish2_id=null;
							$application->study_programs_calls_wish2_call_type=null;
							$application->study_programs_wish2_is_active=null;			
							$application->study_programs_wish2_id=null;
							$application->study_programs_wish2_program_name=null;	
							$application->study_programs_calls_wish2_double_id=null;		
							$application->study_programs_wish2_double_is_active=null;	
							$application->study_programs_wish2_double_id=null;
							$application->study_programs_wish2_double_program_name=null;
							$application->program_carrier_wish2_id=null;
							$application->program_carrier_wish2_institution_name=null;
							array_push($response,$application);
						}
					}
        	}

        	foreach ($applicationsWish1double as $application) {
        		$studyProgramCallWish = StudyProgramCall::find($application->wish1_second_wish);
        			if($studyProgramCallWish)
        			{
        				if($studyProgramCallWish->is_active==1)
        				{
			        		$application->study_programs_calls_wish2_id=null;
			        		$application->study_programs_calls_wish2_call_type=null;
							$application->study_programs_wish2_is_active=null;			
							$application->study_programs_wish2_id=null;
							$application->study_programs_wish2_program_name=null;
							$application->study_programs_calls_wish2_double_id=null;	
							$application->study_programs_wish2_double_is_active=null;			
							$application->study_programs_wish2_double_id=null;
							$application->study_programs_wish2_double_program_name=null;
							$application->program_carrier_wish2_id=null;	
							$application->program_carrier_wish2_institution_name=null;
							$application->study_programs_calls_wish3_id=null;
							$application->study_programs_calls_wish3_call_type=null;
							$application->study_programs_wish3_is_active=null;			
							$application->study_programs_wish3_id=null;
							$application->study_programs_wish3_program_name=null;	
							$application->study_programs_calls_wish3_double_id=null;		
							$application->study_programs_wish3_double_is_active=null;	
							$application->study_programs_wish3_double_id=null;
							$application->study_programs_wish3_double_program_name=null;
							$application->program_carrier_wish3_id=null;
							$application->program_carrier_wish3_institution_name=null;
							array_push($response,$application);
						}
					}
        	}

        	foreach ($applicationsWish2double as $application) {
        		$studyProgramCallWish = StudyProgramCall::find($application->wish2_second_wish);
        			if($studyProgramCallWish)
        			{
        				if($studyProgramCallWish->is_active==1)
        				{
			        		$application->study_programs_calls_wish1_id=null;
			        		$application->study_programs_calls_wish1_call_type=null;
							$application->study_programs_wish1_is_active=null;			
							$application->study_programs_wish1_id=null;
							$application->study_programs_wish1_program_name=null;
							$application->study_programs_calls_wish1_double_id=null;	
							$application->study_programs_wish1_double_is_active=null;			
							$application->study_programs_wish1_double_id=null;
							$application->study_programs_wish1_double_program_name=null;
							$application->program_carrier_wish1_id=null;	
							$application->program_carrier_wish1_institution_name=null;
							$application->study_programs_calls_wish3_id=null;
							$application->study_programs_calls_wish3_call_type=null;
							$application->study_programs_wish3_is_active=null;			
							$application->study_programs_wish3_id=null;
							$application->study_programs_wish3_program_name=null;	
							$application->study_programs_calls_wish3_double_id=null;		
							$application->study_programs_wish3_double_is_active=null;	
							$application->study_programs_wish3_double_id=null;
							$application->study_programs_wish3_double_program_name=null;
							$application->program_carrier_wish3_id=null;
							$application->program_carrier_wish3_institution_name=null;
							array_push($response,$application);
						}
					}
        	}

        	foreach ($applicationsWish3double as $application) {
        		$studyProgramCallWish = StudyProgramCall::find($application->wish3_second_wish);
        			if($studyProgramCallWish)
        			{
        				if($studyProgramCallWish->is_active==1)
        				{
			        		$application->study_programs_calls_wish1_id=null;
			        		$application->study_programs_calls_wish1_call_type=null;
							$application->study_programs_wish1_is_active=null;			
							$application->study_programs_wish1_id=null;
							$application->study_programs_wish1_program_name=null;
							$application->study_programs_calls_wish1_double_id=null;	
							$application->study_programs_wish1_double_is_active=null;			
							$application->study_programs_wish1_double_id=null;
							$application->study_programs_wish1_double_program_name=null;
							$application->program_carrier_wish1_id=null;	
							$application->program_carrier_wish1_institution_name=null;
							$application->study_programs_calls_wish2_id=null;
							$application->study_programs_calls_wish2_call_type=null;
							$application->study_programs_wish2_is_active=null;			
							$application->study_programs_wish2_id=null;
							$application->study_programs_wish2_program_name=null;	
							$application->study_programs_calls_wish2_double_id=null;		
							$application->study_programs_wish2_double_is_active=null;	
							$application->study_programs_wish2_double_id=null;
							$application->study_programs_wish2_double_program_name=null;
							$application->program_carrier_wish2_id=null;
							$application->program_carrier_wish2_institution_name=null;
							array_push($response,$application);
						}
					}
        	}


			
        	return response()->json($response);
 		}
 		else if($user->fk_id_vis_institution!=null && $user->fk_user_role==3)
 		{
 			//prefiltriraj prijavnice glede na id fakultete referenta
 			$idFakulteta = $user->fk_id_vis_institution;
 			$applicationsWish1 = DB::table('applications_view')
								    ->where('study_programs_calls_wish1_id', '!=', null)
								    ->where('program_carrier_wish1_id', '=', $idFakulteta)
								    ->get();
			$applicationsWish2 = DB::table('applications_view')
								    ->where('study_programs_calls_wish2_id', '!=', null)
								    ->where('program_carrier_wish2_id', '=', $idFakulteta)
								    ->get();
			$applicationsWish3 = DB::table('applications_view')
								    ->where('study_programs_calls_wish3_id', '!=', null)
								    ->where('program_carrier_wish3_id', '=', $idFakulteta)
								    ->get();

			$response = [];
        	foreach ($applicationsWish1 as $application) {
        		$studyProgramCallWish = StudyProgramCall::find($application->fk_id_wish1);
        			if($studyProgramCallWish)
        			{
        				if($studyProgramCallWish->is_active==1)
        				{
			        		$application->study_programs_calls_wish2_id=null;
			        		$application->study_programs_calls_wish2_call_type=null;
							$application->study_programs_wish2_is_active=null;			
							$application->study_programs_wish2_id=null;
							$application->study_programs_wish2_program_name=null;
							$application->study_programs_calls_wish2_double_id=null;	
							$application->study_programs_wish2_double_is_active=null;			
							$application->study_programs_wish2_double_id=null;
							$application->study_programs_wish2_double_program_name=null;	
							$application->program_carrier_wish2_id=null;
							$application->program_carrier_wish2_institution_name=null;
							$application->study_programs_calls_wish3_id=null;
							$application->study_programs_calls_wish3_call_type=null;
							$application->study_programs_wish3_is_active=null;			
							$application->study_programs_wish3_id=null;
							$application->study_programs_wish3_program_name=null;	
							$application->study_programs_calls_wish3_double_id=null;		
							$application->study_programs_wish3_double_is_active=null;	
							$application->study_programs_wish3_double_id=null;
							$application->study_programs_wish3_double_program_name=null;
							$application->program_carrier_wish3_id=null;
							$application->program_carrier_wish3_institution_name=null;
							array_push($response,$application);
						}
					}
        	}

        	foreach ($applicationsWish2 as $application) {
        		$studyProgramCallWish = StudyProgramCall::find($application->fk_id_wish2);
        			if($studyProgramCallWish)
        			{
        				if($studyProgramCallWish->is_active==1)
        				{
			        		$application->study_programs_calls_wish1_id=null;
			        		$application->study_programs_calls_wish1_call_type=null;
							$application->study_programs_wish1_is_active=null;			
							$application->study_programs_wish1_id=null;
							$application->study_programs_wish1_program_name=null;
							$application->study_programs_calls_wish1_double_id=null;	
							$application->study_programs_wish1_double_is_active=null;			
							$application->study_programs_wish1_double_id=null;
							$application->study_programs_wish1_double_program_name=null;
							$application->program_carrier_wish1_id=null;
							$application->program_carrier_wish1_institution_name=null;	
							$application->study_programs_calls_wish3_id=null;
							$application->study_programs_calls_wish3_call_type=null;
							$application->study_programs_wish3_is_active=null;			
							$application->study_programs_wish3_id=null;
							$application->study_programs_wish3_program_name=null;	
							$application->study_programs_calls_wish3_double_id=null;		
							$application->study_programs_wish3_double_is_active=null;	
							$application->study_programs_wish3_double_id=null;
							$application->study_programs_wish3_double_program_name=null;
							$application->program_carrier_wish3_id=null;
							$application->program_carrier_wish3_institution_name=null;
							array_push($response,$application);
						}
					}
        	}

        	foreach ($applicationsWish3 as $application) {
        		$studyProgramCallWish = StudyProgramCall::find($application->fk_id_wish3);
        			if($studyProgramCallWish)
        			{
        				if($studyProgramCallWish->is_active==1)
        				{
			        		$application->study_programs_calls_wish1_id=null;
			        		$application->study_programs_calls_wish1_call_type=null;
							$application->study_programs_wish1_is_active=null;			
							$application->study_programs_wish1_id=null;
							$application->study_programs_wish1_program_name=null;
							$application->study_programs_calls_wish1_double_id=null;	
							$application->study_programs_wish1_double_is_active=null;			
							$application->study_programs_wish1_double_id=null;
							$application->study_programs_wish1_double_program_name=null;
							$application->program_carrier_wish1_id=null;	
							$application->program_carrier_wish1_institution_name=null;
							$application->study_programs_calls_wish2_id=null;
							$application->study_programs_calls_wish2_call_type=null;
							$application->study_programs_wish2_is_active=null;			
							$application->study_programs_wish2_id=null;
							$application->study_programs_wish2_program_name=null;	
							$application->study_programs_calls_wish2_double_id=null;		
							$application->study_programs_wish2_double_is_active=null;	
							$application->study_programs_wish2_double_id=null;
							$application->study_programs_wish2_double_program_name=null;
							$application->program_carrier_wish2_id=null;
							$application->program_carrier_wish2_institution_name=null;
							array_push($response,$application);
						}
					}
        	}
        	return response()->json($response);
 		}
 		else
 			 return response()->json(array('error' => 'Not sufficient rights to display applications.'),400);
    }
    
    public function editApplication(Request $request){
    	$user = Auth::user();
    	$id=$request->input('id');
        $fk_id_user=$user->id;
        $address=$request->input('address');
        $fk_id_city_address=$request->input('fk_id_city_address');
        $address_temp=$request->input('address_temp');
        $fk_id_city_address_temp=$request->input('fk_id_city_address_temp');
        $fk_id_citizenship=$request->input('fk_id_citizenship');
        $fk_id_wish1=$request->input('fk_id_wish1');
        $fk_id_wish2=$request->input('fk_id_wish2');
        $fk_id_wish3=$request->input('fk_id_wish3');
        $emso=$request->input('emso');
        $wish1_isdouble_major=$request->input('wish1_isdouble_major');
        $wish2_isdouble_major=$request->input('wish2_isdouble_major');
        $wish3_isdouble_major=$request->input('wish3_isdouble_major');
        $wish1_second_wish=$request->input('wish1_second_wish');
        $wish2_second_wish=$request->input('wish2_second_wish');
        $wish3_second_wish=$request->input('wish3_second_wish');
        $timestamp_created=$request->input('timestamp_created');
        $timestamp_sent=$request->input('timestamp_sent');
        $fk_id_middle_school=$request->input('fk_id_middle_school');
        $contact_phone=$request->input('contact_phone');
        $fk_id_klasius_srv=$request->input('fk_id_klasius_srv');
        $fk_gained_profession=$request->input('fk_gained_profession');
        //$fk_id_status=$request->input('fk_id_status');
        $fk_id_status=2;
        $fk_id_middle_school_completion_type=$request->input('fk_id_middle_school_completion_type');
 		
 		$fk_id_country=$request->input('fk_id_country');
 		$fk_id_country_temp=$request->input('fk_id_country_temp');
 		$fk_id_place_of_birth=$request->input('fk_id_place_of_birth');
        
       
        //dodajanje
        if($fk_id_user && $address && $fk_id_city_address && $address_temp && $fk_id_city_address_temp && $fk_id_citizenship && $fk_id_wish1 && $fk_id_wish2 && $fk_id_wish3 && $emso && $timestamp_created && $timestamp_sent && $fk_id_middle_school && $contact_phone && $fk_id_klasius_srv && $fk_gained_profession && $fk_id_status && $fk_id_middle_school_completion_type)
        {
          if($id==null)
          {
              $application=ApplicationModel::create($request->all());
              return response()->json($application);
          }
          else{
            $application=ApplicationModel::find($id);
            if($application)
            {
                $application->fk_id_user=$fk_id_user;
                $application->address=$address;
                $application->fk_id_city_address=$fk_id_city_address;
                $application->address_temp=$address_temp;
                $application->fk_id_city_address_temp=$fk_id_city_address_temp;
                $application->fk_id_citizenship=$fk_id_citizenship;
                $application->fk_id_wish1=$fk_id_wish1;
                $application->fk_id_wish2=$fk_id_wish2;
                $application->fk_id_wish3=$fk_id_wish3;
                $application->emso=$emso;
                $application->wish1_isdouble_major=$wish1_isdouble_major;
                $application->wish2_isdouble_major=$wish2_isdouble_major;
                $application->wish3_isdouble_major=$wish3_isdouble_major;
                $application->wish1_second_wish=$wish1_second_wish;
                $application->wish2_second_wish=$wish2_second_wish;
                $application->wish3_second_wish=$wish3_second_wish;
                $application->timestamp_created=$timestamp_created;
                $application->timestamp_sent=$timestamp_sent;
                $application->fk_id_middle_school=$fk_id_middle_school;
                $application->contact_phone=$contact_phone;
                $application->fk_id_klasius_srv=$fk_id_klasius_srv;
                $application->fk_gained_profession=$fk_gained_profession;
                $application->fk_id_status=$fk_id_status;
                $application->fk_id_middle_school_completion_type=$fk_id_middle_school_completion_type;

                $application->fk_id_country= $fk_id_country;
                $application->fk_id_country_temp=$fk_id_country_temp;
                $application->fk_id_place_of_birth=$fk_id_place_of_birth;
                $application->save();
                 return response()->json($application);
            }
            else
              return response()->json(array('error' => 'Wrong application id.'),400);
          }
           
        }
          else
            return response()->json(array('error' => 'Wrong or missing input data.'),400);

    }

     public function deleteApplicationById(Request $request){
        $id=$request->input('id');
        if($id)
        {
          $application= ApplicationModel::find($id);
          if($application){
            $application->fk_id_status=3;
            $application->save();
            return response()->json(array('success' => 'Application deleted successfully'));
          }
          else
            return response()->json(array('error' => 'No application with that id.'),400);
        }
        else
           return response()->json(array('error' => 'Wrong or missing id data.'),400);
    }

}
?>
