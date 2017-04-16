<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class StudyProgram extends Model
{ 
	//id fk_id_type fk_id_program_carrier	sequence_number	serial_id	program_name
 	protected $fillable = ['fk_id_type', 'fk_id_program_carrier', 'sequence_number', 'serial_id', 'program_name'];

 	protected $attributes  = ['fk_id_type', 'fk_id_program_carrier', 'sequence_number', 'serial_id', 'program_name'];
 

 	protected $table = 'study_programs';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
