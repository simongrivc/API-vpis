<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class VisInstitution extends Model
{ 
 	protected $fillable = ['id', 'institution_name'];

 	protected $attributes  = ['id', 'institution_name'];
 

 	protected $table = 'vis_institutions';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
