<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class AcceptanceTestResult extends Model
{ 
	
 	
	protected $fillable = ['id', 'fk_id_user','fk_id_program_call', 'grade'];
 /*	protected $attributes  = ['id', 'min_points','max_points', 'fk_id_program_call_conditions'];
*/
 
 	protected $table = 'acceptance_test_results';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
 