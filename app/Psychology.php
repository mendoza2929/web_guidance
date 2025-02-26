<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Psychology extends Model {

	protected $table = 'psychology';
	protected $fillable = ['student_id','img','summary'];

}
