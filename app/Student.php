<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

	protected $table = 'student';
	protected $fillable = ['person_id', 'gen_user_id', 'student_no', 'student_curriculum_id','classification_id','school_department_id','classification_level_id'];

}
