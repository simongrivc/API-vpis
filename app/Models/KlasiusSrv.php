<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class KlasiusSrv extends Model
{ 
	
 	protected $fillable = ['id', 'klasius_nr', 'klasius_name'];

 	protected $attributes  = ['id', 'klasius_nr', 'klasius_name'];

 
 	protected $table = 'klasius_srv';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
