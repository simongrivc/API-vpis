<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class ProgramCallCondition extends Model
{ 
	
 	protected $fillable = ['id', 'must_have', 'fk_condition_code_id', 'fk_program_call_id', 'condition_weight'];

 	protected $attributes  = ['id', 'must_have', 'fk_condition_code_id', 'fk_program_call_id', 'condition_weight'];

 
 	protected $table = 'program_call_conditions';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}