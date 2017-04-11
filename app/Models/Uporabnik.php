<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Uporabnik extends Model
{ 
 	protected $fillable = ['IdUporabnik', 'ImeUporabnik'];

 	protected $table = 'uporabniki';
 	  protected $primaryKey = 'IdUporabnik';
}
?>