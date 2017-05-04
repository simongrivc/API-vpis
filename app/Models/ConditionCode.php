<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class ConditionCode extends Model
{ 
	
 	protected $fillable = ['id', 'condition_code_name'];

 	protected $attributes  = ['id', 'condition_code_name'];

 
 	protected $table = 'condition_codes';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
