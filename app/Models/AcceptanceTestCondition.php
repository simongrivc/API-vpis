<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class AcceptanceTestCondition extends Model
{ 
	
 	protected $fillable = ['id', 'min_points','max_points', 'fk_id_program_call_conditions'];

 /*	protected $attributes  = ['id', 'min_points','max_points', 'fk_id_program_call_conditions'];
*/
 
 	protected $table = 'acceptance_test_condition';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
 