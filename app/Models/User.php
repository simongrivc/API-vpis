<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class User extends Model
{ 
 	protected $fillable = ['api_token', 'activation_code', 'username', 'email', 'is_active', 'name', 'surname'];

 	protected $attributes  = ['api_token', 'activation_code', 'username', 'email', 'is_active', 'name', 'surname'];
 
 	protected $hidden = [
        'password',
    ];

 	protected $table = 'users';
}
