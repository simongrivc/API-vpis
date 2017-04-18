<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class StudyProgramCallView extends Model
{ 
	//id fk_id_type fk_id_program_carrier	sequence_number	serial_id	program_name
 	protected $fillable = ['id', 'fk_id_type', 'fk_id_program_carrier', 'sequence_number', 'serial_id', 'program_name', 'type_name', 'institution_name', 'abbreviation', 'fk_id_municipality', 'fk_id_university', 'municipality_name', 'university_name', 'fk_id_call_type', 'call_type_name', 'nr_slo_eu', 'nr_foreigners', 'nr_without_citizenship','min_nr_points','nr_slo_eu_vpis_mock' => '0', 'nr_foreigners_vpis_mock' => '0', 'nr_without_citizenship_vpis_mock' => '0', 'nr_slo_eu_sprejeti_mock' => '0', 'nr_foreigners_sprejeti_mock' => '0', 'nr_without_citizenship_sprejeti_mock' => '0'];

 	protected $attributes  = ['id', 'fk_id_type', 'fk_id_program_carrier', 'sequence_number', 'serial_id', 'program_name', 'type_name', 'institution_name', 'abbreviation', 'fk_id_municipality', 'fk_id_university', 'municipality_name', 'university_name', 'fk_id_call_type', 'call_type_name', 'nr_slo_eu', 'nr_foreigners', 'nr_without_citizenship','min_nr_points','nr_slo_eu_vpis_mock' => '0', 'nr_foreigners_vpis_mock' => '0', 'nr_without_citizenship_vpis_mock' => '0', 'nr_slo_eu_sprejeti_mock' => '0', 'nr_foreigners_sprejeti_mock' => '0', 'nr_without_citizenship_sprejeti_mock' => '0'];
 	
/* 	protected $appends = ['nr_slo_eu_vpis_mock' => '0', 'nr_foreigners_vpis_mock' => '0', 'nr_without_citizenship_vpis_mock' => '0', 'nr_slo_eu_sprejeti_mock' => '0', 'nr_foreigners_sprejeti_mock' => '0', 'nr_without_citizenship_sprejeti_mock' => '0'];
*/
 	protected $table = 'study_programs_calls_view';
 	//da eloquent ne dodaja timestamp v bazo
 	public $timestamps  = false;
}
