<?php namespace App\Http\Controllers;

use App\Citizenship;
use App\CivilStatus;
use App\EducationalBackground;
use App\FamilyBackground;
use App\Gender;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\OtherSurvey;
use App\Person;
use App\Religion;
use App\Student;
use App\Survey;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class StudentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$religion_list = Religion::all();
		$citizenship_list = Citizenship::all();
		$civil_status_list = CivilStatus::all();
		

		return view('student.index',compact('religion_list','citizenship_list','gender_list','civil_status_list'));
	}
	public function chatBot(Request $request)
	{
		session_start(); // Start a session to store conversation state
	
		$question = strtolower(trim($request->input('question')));
		$conversation_state = isset($_SESSION['chat_state']) ? $_SESSION['chat_state'] : '';
	
		// Predefined responses
		$responses = [
			'family problem' => [
				"I'm really sorry to hear that. Do you want to talk about what's been bothering you?",
				"That sounds really stressful. Have you tried talking to someone you trust, like a teacher or counselor?",
				"It's okay to feel overwhelmed. Sometimes writing down your feelings before talking to someone can help.",
				"Would you like some advice on how to express your feelings to someone who can help?"
			],
			'help me' => [
				"Of course! I'm here to listen. Can you tell me a bit more about your situation?",
				"I'm happy to help. Are you looking for advice or just someone to listen?",
				"Would you like me to suggest some steps to handle this situation?"
			],
			'recommendation' => [
				"Here are some things you can try:  
				1️⃣ Find a safe space to talk about your feelings.  
				2️⃣ Write down your thoughts before discussing them.  
				3️⃣ Reach out to a school counselor or trusted teacher.",
				"You can try mindfulness exercises to reduce stress. Would you like some breathing techniques?",
				"Sometimes talking to a friend who understands can make a big difference. Have you tried that?"
			]
		];
	
		$answer = "I'm here to help. Can you describe your concern in more detail?";
	
		// Detecting previous conversation state
		if ($conversation_state === 'family_problem') {
			$answer = $responses['help me'][array_rand($responses['help me'])]; // Random response from 'help me'
		} elseif ($conversation_state === 'help_me') {
			$answer = $responses['recommendation'][array_rand($responses['recommendation'])]; // Random recommendation
		} else {
			foreach ($responses as $keyword => $responseArray) {
				if (strpos($question, $keyword) !== false) {
					$_SESSION['chat_state'] = $keyword; // Store conversation state
					$answer = $responseArray[array_rand($responseArray)];
					break;
				}
			}
		}
	
		return response()->json(['response' => $answer]);
	}
	



	public function createPds()
	{

		// dd(\Request::all());
		$first_name = \Request::input('first_name');
		$last_name = \Request::input('last_name');
		$middle_name = \Request::input('middle_name');
		$today_date = \Request::input('today_date');
		$address = \Request::input('address');
		$place_of_birth = \Request::input('place_of_birth');
		$religion_id = \Request::input('religion_id');
		$student_email = \Request::input('student_email');
		$gender_id = \Request::input('gender_id');
		$civil_status_id = \Request::input('civil_status_id');
		$birthdate = \Request::input('birthdate');
		$citizenship_id = \Request::input('citizenship_id');
		$student_mobile_no = \Request::input('student_mobile_no');
		$workingStudent = \Request::input('workingStudent');
		$scholar = \Request::input('scholar');
		$singleParent = \Request::input('singleParent');
		$who_guardian = \Request::input('who_guardian');
		$who_sponsor = \Request::input('who_sponsor');
		$many_children = \Request::input('many_children');
		$married = \Request::input('married');
		$no_bro = \Request::input('no_bro');
		$father_name = \Request::input('father_name');
		$father_age = \Request::input('father_age');
		$father_address = \Request::input('father_address');
		$father_educational = \Request::input('father_educational');
		$father_occupation = \Request::input('father_occupation');
		$father_number = \Request::input('father_number');
		$no_sis = \Request::input('no_sis');
		$mother_name = \Request::input('mother_name');
		$mother_age = \Request::input('mother_age');
		$mother_address = \Request::input('mother_address');
		$mother_educational = \Request::input('mother_educational');
		$mother_occupation = \Request::input('mother_occupation');
		$mother_number = \Request::input('mother_number');
		$elem = \Request::input('elem');
		$elem_sub_like = \Request::input('elem_sub_like');
		$elem_sub_not_like = \Request::input('elem_sub_not_like');
		$jhs = \Request::input('jhs');
		$jhs_sub_like = \Request::input('jhs_sub_like');
		$jhs_sub_not_like = \Request::input('jhs_sub_not_like');
		$g11 = \Request::input('g11');
		$g11_sub_like = \Request::input('g11_sub_like');
		$g11_sub_not_like = \Request::input('g11_sub_not_like');
		$g12 = \Request::input('g12');
		$g12_sub_like = \Request::input('g12_sub_like');
		$g12_sub_not_like = \Request::input('g12_sub_not_like');
		$college = \Request::input('college');
		$college_sub_like = \Request::input('college_sub_like');
		$college_sub_not_like = \Request::input('college_sub_not_like');
		$easiest = \Request::input('easiest');
		$most_diff_sub = \Request::input('most_diff_sub');
		$subj_lowest = \Request::input('subj_lowest');
		$subj_highest = \Request::input('subj_highest');
		$subj_highest_grade = \Request::input('subj_highest_grade');
		$plan_after_hs = \Request::input('plan_after_hs');
		$award = \Request::input('award');
		$emergency_contact = \Request::input('emergency_contact');



		$person = Person::create([
			'first_name' => $first_name,
			'last_name' => $last_name,
			'email_address' => $student_email,
			'middle_name' => $middle_name,
			'date_input' => $today_date,
			'gender_id' => $gender_id,
			'civil_status_id' => $civil_status_id,
			'citizenship_id' => $citizenship_id,
			'mobile_number' => $student_mobile_no,
			'address' => $address,
			'place_of_birth' => $place_of_birth,
			'religion_id' => $religion_id,
			'birthdate' => $birthdate,
			'incase_of_emergency' => $emergency_contact,
		]);

		$family_background = FamilyBackground::create([
			'person_id' => $person->id,
			'no_brother' => $no_bro,
			'no_sister' => $no_sis,
			'father_name' => $father_name,
			'mother_name' => $mother_name,
			'father_age' => $father_age,
			'mother_age' => $mother_age,
			'father_address' => $father_address,
			'mother_address' => $mother_address,
			'father_educational' => $father_educational,
			'mother_educational' => $mother_educational,
			'father_occupation' => $father_occupation,
			'mother_occupation' => $mother_occupation,
			'father_mobile' => $father_number,
			'mother_mobile' => $mother_number
		]);

		$survey = Survey::create([
			'person_id' => $person->id,
			'working_student' => $workingStudent,
			'scholar' => $scholar,
			'single_parent' => $singleParent,
			'guardian' => $who_guardian,
			'sponsor' => $who_sponsor,
			'children' => $many_children,
			'married' => $married,
		]);


		$educational_background = EducationalBackground::create([
			'person_id' => $person->id,
			'elem_school' => $elem,
			'elem_subject_like' => $elem_sub_like,
			'elem_subject_not_like' => $elem_sub_not_like,
			'jhs_school' => $jhs,
			'jhs_subject_like' => $jhs_sub_like,
			'jhs_subject_not_like' => $jhs_sub_not_like,
			'g11_school' => $g11,
			'g11_subject_like' => $g11_sub_like,
			'g11_subject_not_like' => $g11_sub_not_like,
			'g12_school' => $g12,
			'g12_subject_like' => $g12_sub_like,
			'g12_subject_not_like' => $g12_sub_not_like,
			'college_school' => $college,
			'college_subject_like' => $college_sub_like,
			'college_subject_not_like' => $college_sub_not_like,
		]);

		$other_survey = OtherSurvey::create([
			'person_id' => $person->id,
			'easiest_sub' => $easiest,
			'most_difficult_sub' => $most_diff_sub,
			'sub_with_lowest' => $subj_lowest,
			'sub_with_highest' => $subj_highest_grade,
			'plan_after_hs' => $plan_after_hs,
			'awards' => $award,
		]);

		$student = Student::create([
			'person_id' => $person->id, 
		]);
		$users = User::create([
			'person_id' => $person->id,
			'name' => $person->last_name,
			'role' => 'student',
			'email' => $person->email_address, 
			'password' => Hash::make($person->last_name)
		]);
		
		return response()->json(['success' => true, 'person' => $person, 'student' => $student, 'user' => $users, 'family_background' => $family_background, 'educational_background' => $educational_background, 'other_survey' => $other_survey, 'survey' => $survey]);
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//

		dd($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
