<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Application extends Model
{ 
	//id fk_id_type fk_id_program_carrier	sequence_number	serial_id	program_name
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
							'email',
							'username',
							'name',
							'surname',
							'is_active',
							'city_address_name',
							'city_address_number',
							'city_address_temp_name',
							'city_address_temp_number',
							'id_citizenship',
							'citizenship_name',
							'study_programs_calls_wish1_id',
							'study_programs_wish1_is_active',
							'study_programs_wish1_id',
							'study_programs_wish1_program_name',
							'program_carrier_wish1_id',
							'study_programs_calls_wish1_double_id',
							'study_programs_wish1_double_is_active',
							'study_programs_wish1_double_id',
							'study_programs_wish1_double_program_name',
							'study_programs_calls_wish2_id',
							'study_programs_wish2_is_active',
							'study_programs_wish2_id',
							'study_programs_wish2_program_name',
							'program_carrier_wish2_id',
							'study_programs_calls_wish2_double_id',
							'study_programs_wish2_double_is_active',
							'study_programs_wish2_double_id',
							'study_programs_wish2_double_program_name',
							'study_programs_calls_wish3_id',
							'study_programs_wish3_is_active',
							'study_programs_wish3_id',
							'study_programs_wish3_program_name',
							'program_carrier_wish3_id',
							'study_programs_calls_wish3_double_id',
							'study_programs_wish3_double_is_active',
							'study_programs_wish3_double_id',
							'study_programs_wish3_double_program_name',
							'middle_school_id',
							'middle_school_name',
							'klasius_srv_id',
							'klasius_nr',
							'klasius_name',
							'gained_profession_id',
							'gained_profession_name',
							'application_status_id',
							'application_status_name'];

 	protected $attributes  = ['id',
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
							'email',
							'username',
							'name',
							'surname',
							'is_active',
							'city_address_name',
							'city_address_number',
							'city_address_temp_name',
							'city_address_temp_number',
							'id_citizenship',
							'citizenship_name',
							'study_programs_calls_wish1_id',
							'study_programs_wish1_is_active',
							'study_programs_wish1_id',
							'study_programs_wish1_program_name',
							'study_programs_calls_wish1_double_id',
							'study_programs_wish1_double_is_active',
							'study_programs_wish1_double_id',
							'study_programs_wish1_double_program_name',
							'study_programs_calls_wish2_id',
							'study_programs_wish2_is_active',
							'study_programs_wish2_id',
							'study_programs_wish2_program_name',
							'study_programs_calls_wish2_double_id',
							'study_programs_wish2_double_is_active',
							'study_programs_wish2_double_id',
							'study_programs_wish2_double_program_name',
							'study_programs_calls_wish3_id',
							'study_programs_wish3_is_active',
							'study_programs_wish3_id',
							'study_programs_wish3_program_name',
							'study_programs_calls_wish3_double_id',
							'study_programs_wish3_double_is_active',
							'study_programs_wish3_double_id',
							'study_programs_wish3_double_program_name',
							'middle_school_id',
							'middle_school_name',
							'klasius_srv_id',
							'klasius_nr',
							'klasius_name',
							'gained_profession_id',
							'gained_profession_name',
							'application_status_id',
							'application_status_name'];
 	
 	protected $table = 'applications';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
