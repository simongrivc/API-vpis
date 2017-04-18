<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class User extends Model
{ 
 	protected $fillable = ['api_token', 'activation_code', 'username', 'email', 'is_active', 'name', 'surname', 'last_login','fk_id_vis_institution', 'vis_institution_name'];

 	protected $attributes  = ['api_token', 'activation_code', 'username', 'email', 'is_active', 'name', 'surname', 'fk_activation_code', 'fk_user_role', 'last_login', 'fk_id_vis_institution'];
 
 	protected $hidden = [
        'password',
    ];

 	protected $table = 'users';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
