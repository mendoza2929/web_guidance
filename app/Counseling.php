<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Counseling extends Model {

	protected $table = 'counseling';
	protected $fillable = ['student_id','img','summary'];

}
