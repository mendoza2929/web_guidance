<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AptitudeResults extends Model {

	protected $table = 'aptitude_results';
	protected $fillable = ['question_id','answer_id','student_id','is_correct'];

}
