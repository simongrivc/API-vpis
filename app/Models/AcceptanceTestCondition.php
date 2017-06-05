<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class AcceptanceTestCondition extends Model
{ 
	
 	protected $fillable = ['id', 'condition_weight', 'fk_condition_code_id', 'fk_condition_group', 'id_acceptance_test_condition','min_points','max_points','condition_code_name','fk_program_call_id','fk_id_study_program','program_name','fk_id_program_carrier'];

 	protected $attributes  = ['id', 'condition_weight', 'fk_condition_code_id', 'fk_condition_group', 'id_acceptance_test_condition','min_points','max_points','condition_code_name','fk_program_call_id','fk_id_study_program','program_name','fk_id_program_carrier'];

 
 	protected $table = 'acceptance_test_conditions';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
 