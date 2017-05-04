<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class CallGroup extends Model
{ 
	
 	protected $fillable = ['id', 'group_call_name', 'timestamp_start_date', 'timestamp_end_date', 'is_active'];

 	protected $attributes  = ['id', 'group_call_name', 'timestamp_start_date', 'timestamp_end_date', 'is_active'];

 
 	protected $table = 'call_groups';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
