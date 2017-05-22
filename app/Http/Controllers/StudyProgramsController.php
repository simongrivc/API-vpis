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
 
class StudyProgramsController extends Controller{

    public function index(){
 
        $studyPrograms = StudyProgram::all();
        return response()->json($studyPrograms);
    }
 
    public function getStudyProgramById(Request $request, $id){

        $studyProgram = StudyProgram::find($id);

        return response()->json($studyProgram);
    }

    public function getStudyProgramCallsActive(Request $request){
        
        $studyProgramCalls = StudyProgramCallView::where('is_active', '!=', 0)->get();
        if($studyProgramCalls)
        {
          foreach ($studyProgramCalls as $program) {
            
            $programId = $program->id;
            $stWish1SloEu = Application_view::where('study_programs_calls_wish1_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 1)->count();
            $stWish2SloEu = Application_view::where('study_programs_calls_wish2_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 1)->count();
            $stWish3SloEu = Application_view::where('study_programs_calls_wish3_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 1)->count();

            $stWish1SloEuDouble = Application_view::where('study_programs_calls_wish1_double_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 1)->count();
            $stWish2SloEuDouble = Application_view::where('study_programs_calls_wish2_double_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 1)->count();
            $stWish3SloEuDouble = Application_view::where('study_programs_calls_wish3_double_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 1)->count();

            $stWish1Foreigners = Application_view::where('study_programs_calls_wish1_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 2)->count();
            $stWish2Foreigners = Application_view::where('study_programs_calls_wish2_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 2)->count();
            $stWish3Foreigners = Application_view::where('study_programs_calls_wish3_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 2)->count();

            $stWish1ForeignersDouble = Application_view::where('study_programs_calls_wish1_double_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 2)->count();
            $stWish2ForeignersDouble = Application_view::where('study_programs_calls_wish2_double_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 2)->count();
            $stWish3ForeignersDouble = Application_view::where('study_programs_calls_wish3_double_id', '=', $programId)
                                      ->where('fk_id_citizenship', '=', 2)->count();

              $program->nr_slo_eu_applications = $stWish1SloEu + $stWish2SloEu + $stWish3SloEu + $stWish1SloEuDouble + $stWish2SloEuDouble + $stWish3SloEuDouble;

              $program->nr_foreigners_applications = $stWish1Foreigners + $stWish2Foreigners + $stWish3Foreigners + $stWish1ForeignersDouble + $stWish2ForeignersDouble + $stWish3ForeignersDouble;

       
            $program->nr_slo_eu_accepted = 0;
            $program->nr_foreigners_accepted =0;
            
            //pridobivanje vseh group za ta program
            $condGroups = DB::table('condition_groups')
                      ->where('fk_program_call_id', '=', $programId)
                      ->get();
                      
            foreach($condGroups as $group){
                $conditions = DB::table('program_call_conditions')
                      ->where('fk_condition_group', '=', $group->id)
                      ->get();
                $group->conditions = $conditions;
            }
            
            $program->enroll_conds = $condGroups;
           
          }
          return response()->json($studyProgramCalls);
        }
        //$studyProgramCalls = DB::select("SELECT * FROM study_programs_calls_view");

        return response()->json([]);
    }
    
    //dobi vse razpisane programe na posameznem razpisu
     public function getStudyProgramCallsActiveFromGroup(Request $request, $id){
        if($id>0)
        {
          //$studyProgramCalls = StudyProgramCallView::where('is_active', '!=', 0)->get();
          $studyProgramCalls = DB::table('study_programs_calls_view')
                      ->where('is_active', '!=', 0)
                      ->where('fk_id_call_group', '=', $id)
                      ->get();
          if($studyProgramCalls)
          {
            foreach ($studyProgramCalls as $program) {
              $programId = $program->id;
              $program->nr_slo_eu_applications =  Application_view::where(function ($query) use ($programId) {
                                                    $query->where('study_programs_calls_wish1_id', '=', $programId)
                                                              ->orWhere('study_programs_calls_wish2_id', '=',  $programId)
                                                              ->orWhere('study_programs_calls_wish3_id', '=',  $programId)
                                                              ->orWhere('study_programs_calls_wish1_double_id', '=',  $programId)
                                                            ->orWhere('study_programs_calls_wish2_double_id', '=',  $programId)
                                                            ->orWhere('study_programs_calls_wish3_double_id', '=',  $programId);
                                                    })->where(function ($query) {
                                                        $query->where('fk_id_citizenship', '=', 1);          
                                                  })->count();
              $program->nr_foreigners_applications = Application_view::where(function ($query) use ($programId) {
                                                      $query->where('study_programs_calls_wish1_id', '=', $programId)
                                                                ->orWhere('study_programs_calls_wish2_id', '=',  $programId)
                                                                ->orWhere('study_programs_calls_wish3_id', '=',  $programId)
                                                                ->orWhere('study_programs_calls_wis1_double_id', '=',  $programId)
                                                            ->orWhere('study_programs_calls_wish2_double_id', '=',  $programId)
                                                            ->orWhere('study_programs_calls_wish3_double_id', '=',  $programId);
                                                      })->where(function ($query) {
                                                          $query->where('fk_id_citizenship', '=', 2);          
                                                    })->count();
              $program->nr_slo_eu_accepted =0;
              $program->nr_foreigners_accepted =0;
            }
            return response()->json($studyProgramCalls);
          }
          //$studyProgramCalls = DB::select("SELECT * FROM study_programs_calls_view");

         return response()->json([]);

        }
        else
            return response()->json(array('error' => 'Wrong call group id.'),400);
        
    }

    public function deleteStudyProgramCallById(Request $request){
        $id=$request->input('id');
        if($id)
        {
          $studyProgramCall= StudyProgramCall::find($id);
          if($studyProgramCall){
            $studyProgramCall->is_active=0;
            $studyProgramCall->save();
            return response()->json(array('success' => 'Program call deleted successfully'));
          }
          else
            return response()->json(array('error' => 'No program call with that id.'),400);
        }
        else
           return response()->json(array('error' => 'Wrong or missing id data.'),400);
    }
    
    public function addStudyProgramCallById(Request $request){
        $fk_id_call_type=$request->input('fk_id_call_type');
        $nr_slo_eu=$request->input('nr_slo_eu');
        $nr_without_citizenship_foreigners=$request->input('nr_without_citizenship_foreigners');
        $fk_id_study_program=$request->input('fk_id_study_program');
        $min_nr_points=$request->input('min_nr_points');
        $fk_id_call_group=$request->input('fk_id_call_group');

        if($fk_id_call_type>0 && $nr_slo_eu>=0 &&  $nr_without_citizenship_foreigners>=0 && $fk_id_study_program>0 && $min_nr_points>=0 && $fk_id_call_group>0)
        {
            
            $ProgramCall=StudyProgramCall::create($request->all());


            return response()->json($ProgramCall);
        }
          else
            return response()->json(array('error' => 'Wrong or missing input data.'),400);
    
    }

    public function editStudyProgramCall(Request $request){
        $id=$request->input('id');
        $fk_id_call_type=$request->input('fk_id_call_type');
        $nr_slo_eu=$request->input('nr_slo_eu');
        $nr_without_citizenship_foreigners=$request->input('nr_without_citizenship_foreigners');
        $fk_id_study_program=$request->input('fk_id_study_program');
        $min_nr_points=$request->input('min_nr_points');
        $fk_id_call_group=$request->input('fk_id_call_group');
        $is_active=$request->input('is_active');
        //dodajanje
        if($fk_id_call_type>0 && $nr_slo_eu>=0 &&  $nr_without_citizenship_foreigners>=0 && $fk_id_study_program>0 && $min_nr_points>=0 && $fk_id_call_group>0 && $is_active>=0)
        {
          if($id==null)
          {
              $ProgramCall=StudyProgramCall::create($request->all());
              return response()->json($ProgramCall);
          }
          else{
            $ProgramCall=StudyProgramCall::find($id);
            if($ProgramCall)
            {
                $ProgramCall->fk_id_call_type=$fk_id_call_type;
                $ProgramCall->nr_slo_eu=$nr_slo_eu;
                $ProgramCall->nr_without_citizenship_foreigners=$nr_without_citizenship_foreigners;
                $ProgramCall->fk_id_study_program=$fk_id_study_program;
                $ProgramCall->min_nr_points=$min_nr_points;
                $ProgramCall->fk_id_call_group=$fk_id_call_group;
                $ProgramCall->is_active=$is_active;
                $ProgramCall->save();
                 return response()->json($ProgramCall);
            }
            else
              return response()->json(array('error' => 'Wrong study call id.'),400);
          }
           
        }
          else
            return response()->json(array('error' => 'Wrong or missing input data.'),400);
    
    }

}
?>
