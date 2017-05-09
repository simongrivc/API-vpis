<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Country extends Model
{ 
	
 	protected $fillable = ['id', 'country_name', 'iso_name'];

 	protected $attributes  = ['id', 'country_name', 'iso_name'];

 
 	protected $table = 'countries';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
