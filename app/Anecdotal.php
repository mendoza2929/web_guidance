<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Anecdotal extends Model {

	protected $table = 'anecdotal';
	protected $fillable = ['student_id','img','summary'];

}
