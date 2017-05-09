<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Application extends Model
{ 
 	protected $fillable = ['id',
							'fk_id_user',
							'address',
							'fk_id_city_address',
							'address_temp',
							'fk_id_city_address_temp',
							'fk_id_citizenship',
							'fk_id_wish1',
							'fk_id_wish2',
							'fk_id_wish3',
							'emso',
							'wish1_isDouble_major' ,
							'wish2_isDouble_major',
							'wish3_isDouble_major',
							'wish1_second_wish',
							'wish2_second_wish',
							'wish3_second_wish',
							'timestamp_created',
							'timestamp_sent',
							'fk_id_middle_school',
							'contact_phone',
							'fk_id_klasius_srv',
							'fk_gained_profession',
							'fk_id_status',
							'fk_id_middle_school_completion_type'
							];

 	/*protected $attributes  = ['id',
							'fk_id_user',
							'address',
							'fk_id_city_address',
							'address_temp',
							'fk_id_city_address_temp',
							'fk_id_citizenship',
							'fk_id_wish1',
							'fk_id_wish2',
							'fk_id_wish3',
							'emso',
							'wish1_isDouble_major' ,
							'wish2_isDouble_major',
							'wish3_isDouble_major',
							'wish1_second_wish',
							'wish2_second_wish',
							'wish3_second_wish',
							'timestamp_created',
							'timestamp_sent',
							'fk_id_middle_school',
							'contact_phone',
							'fk_id_klasius_srv',
							'fk_gained_profession',
							'fk_id_status',
							'fk_id_middle_school_completion_type'
							];*/
 	
 	protected $table = 'applications';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}

