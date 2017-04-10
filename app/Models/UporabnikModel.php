<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
 
class Uporabnik extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract
{ 
	use Authenticatable, Authorizable;
 	protected $fillable = ['IdUporabnik', 'ImeUporabnik'];

 	protected $table = 'uporabniki';
 	protected $primaryKey = 'IdUporabnik';

 	/*protected $hidden = [
        'password',
    ];*/

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
?>