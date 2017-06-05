<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Study_program_call_with_acceprance_test extends Model
{ 
	
 	protected $fillable = ['fk_program_call_id', 'program_name', 'fk_id_program_carrier', 'fk_id_call_type'];

 	protected $attributes  = ['fk_program_call_id', 'program_name', 'fk_id_program_carrier', 'fk_id_call_type'];

 
 	protected $table = 'study_program_calls_with_acceprance_tests';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}