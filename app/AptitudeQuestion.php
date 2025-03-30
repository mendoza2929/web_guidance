<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AptitudeQuestion extends Model {

	protected $table = 'aptitude_question';
	protected $fillable = ['question','classification_id','classification_level_id'];
}
