<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class University extends Model
{ 
	
 	protected $fillable = ['id', 'University_name'];

 	protected $attributes  = ['id', 'University_name'];

 
 	protected $table = 'universities';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
