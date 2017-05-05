<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class StudyProgramCall extends Model
{ 
	//id fk_id_type fk_id_program_carrier	sequence_number	serial_id	program_name
 	protected $fillable = ['id','fk_id_call_type', 'fk_id_call_group','nr_slo_eu', 'nr_without_citizenship_foreigners', 'fk_id_study_program', 'min_nr_points', 'is_active'];
 
 	protected $table = 'study_programs_calls';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
