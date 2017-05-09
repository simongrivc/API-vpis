<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class MiddleSchoolCompletionType extends Model
{ 
	
 	protected $fillable = ['id', 'completion_type_name'];

 	protected $attributes  = ['id', 'completion_type_name'];

 
 	protected $table = 'middle_school_completion_type';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
