<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AptitudeChoices extends Model {

	protected $table = 'aptitude_choices';
	protected $fillable = ['question_id','choices'];
}
