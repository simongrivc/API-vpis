<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Ip_log extends Model
{
	const CREATED_AT = 'time_stamp';
    const UPDATED_AT = 'time_stamp';
	protected $dateFormat = 'U';
	
 	protected $fillable = ['ip_number'];

 	protected $attributes  = ['ip_number'];
 
 	protected $table = 'ip_logs';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = true;
}
