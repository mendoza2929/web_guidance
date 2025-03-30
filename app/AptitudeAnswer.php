<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AptitudeAnswer extends Model {

	protected $table = 'aptitude_choices';
	protected $fillable = ['question_id','answer_choices_id'];

}
