<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class City extends Model
{ 
	
 	protected $fillable = ['id', 'city_number', 'city_name'];

 	protected $attributes  = ['id', 'city_number', 'city_name'];

 
 	protected $table = 'cities';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
