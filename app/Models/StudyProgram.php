<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class StudyProgram extends Model
{ 
	//id fk_id_type fk_id_program_carrier	sequence_number	serial_id	program_name
 	protected $fillable = ['id', 'fk_id_type', 'fk_id_program_carrier', 'sequence_number', 'serial_id', 'program_name', 'type_name', 'institution_name', 'abbreviation', 'fk_id_municipality', 'fk_id_university', 'municipality_name', 'university_name'];

 	protected $attributes  = ['id', 'fk_id_type', 'fk_id_program_carrier', 'sequence_number', 'serial_id', 'program_name', 'type_name', 'institution_name', 'abbreviation', 'fk_id_municipality', 'fk_id_university', 'municipality_name', 'university_name'];
 
 	protected $table = 'study_programs_view';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
