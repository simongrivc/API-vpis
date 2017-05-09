<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class ConditionGroup extends Model
{ 
	
 	protected $fillable = ['id', 'fk_program_call_id'];

 	protected $attributes  = ['id', 'fk_program_call_id'];

 
 	protected $table = 'condition_groups';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}