<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Ip_log extends Model
{
 	protected $fillable = ['ip_number', 'time_stamp'];

 	protected $attributes  = ['ip_number', 'time_stamp'];
 
 	protected $table = 'ip_logs';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
