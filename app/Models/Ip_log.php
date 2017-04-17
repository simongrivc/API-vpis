<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Ip_log extends Model
{ 
 	protected $fillable = ['ip_number'];

 	protected $attributes  = ['ip_number'];
 
 	protected $table = 'ip_logs';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = true;
}
