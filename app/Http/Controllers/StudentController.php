<?php namespace App\Http\Controllers;

use App\AptitudeChoices;
use App\AptitudeQuestion;
use App\AptitudeResults;
use App\ChatbotConversation;
use App\Citizenship;
use App\CivilStatus;
use App\Classification;
use App\ClassificationLevel;
use App\EducationalBackground;
use App\FamilyBackground;
use App\Gender;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\OtherSurvey;
use App\Person;
use App\Religion;
use App\SchoolDepartment;
use App\Student;
use App\Survey;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
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


		$gen_user = Auth::user()->id;

		$user = User::find($gen_user);


		$person_details = Person::where('id',$user->person_id)->first();
		// dd($person_details);

		if($user->is_new == 1){
			return view('student.index',compact('religion_list','citizenship_list','gender_list','civil_status_list','person_details'));
		}else{
			return view('student.student_portal');
		}


		

		// return view('student.index',compact('religion_list','citizenship_list','gender_list','civil_status_list'));
	}
// 	public function aptitudeTest(Request $request)
// {
//     $gen_user = Auth::user()->person_id;
//     $user = Student::find($gen_user);

//     // Check if the student has already completed the test
//     $hasResults = AptitudeResults::where('student_id', $user->id)->exists();

//     $aptitude_questions = AptitudeQuestion::join('classification', 'aptitude_question.classification_id', '=', 'classification.id')
//         ->leftJoin('classification_level', 'aptitude_question.classification_level_id', '=', 'classification_level.id')
//         ->join('aptitude_choices', 'aptitude_question.id', '=', 'aptitude_choices.question_id')
//         ->where('aptitude_question.classification_id', $user->classification_id)
//         ->select(
//             'aptitude_question.*',
//             'aptitude_choices.id as choice_id',
//             'aptitude_choices.choices as choices',
//             'aptitude_choices.is_correct'
//         )
//         ->orderByRaw('RAND()')
//         ->get();
	

//     $questions = [];
//     foreach ($aptitude_questions as $item) {
//         $question_id = $item->id;
//         if (!isset($questions[$question_id])) {
//             $questions[$question_id] = [
//                 'id' => $item->id,
//                 'question' => $item->question,
//                 'choices' => [],
//             ];
//         }
//         $questions[$question_id]['choices'][] = [
//             'id' => $item->choice_id,
//             'choice' => $item->choices,
//             'is_correct' => $item->is_correct,
//         ];
//     }
//     $questions = array_values($questions);

//     // Store questions in session to maintain order
//     if (!session()->has('aptitude_questions')) {
//         session(['aptitude_questions' => $questions]);
//     } else {
//         $questions = session('aptitude_questions');
//     }

//     $current_question_index = (int) $request->query('question', 0);
//     $test_started = $request->query('start', false);

//     if (!$test_started) {
//         return view('student.aptitude_test_intro', [
//             'total_questions' => count($questions),
//             'hasResults' => $hasResults, // Pass the flag to the intro view
//         ]);
//     }

//     if ($current_question_index < 0 || $current_question_index >= count($questions)) {
//         $current_question_index = 0;
//     }

//     return view('student.aptitude_test', [
//         'questions' => $questions,
//         'current_question_index' => $current_question_index,
//         'total_questions' => count($questions),
//         'hasResults' => $hasResults, // Pass the flag to the test view
//     ]);
// }

public function aptitudeTest(Request $request)
{
    $gen_user = Auth::user()->person_id;
    $user = Student::find($gen_user);
    $classification_id = $user->classification_id;
    $classification_level_id = $user->classification_level_id;

    $hasResults = AptitudeResults::where('student_id', $user->id)->exists();

    // Build the query for aptitude questions
    $query = AptitudeQuestion::join('classification', 'aptitude_question.classification_id', '=', 'classification.id')
        ->leftJoin('classification_level', 'aptitude_question.classification_level_id', '=', 'classification_level.id')
        ->join('aptitude_choices', 'aptitude_question.id', '=', 'aptitude_choices.question_id')
        ->where('aptitude_question.classification_id', $classification_id);

    // Apply classification_level_id filter only for specific classification_ids (e.g., 1 and 2)
    if (in_array($classification_id, [1, 2]) && !is_null($classification_level_id)) {
        $query->where('aptitude_question.classification_level_id', $classification_level_id);
    }

    // Execute the query
    $aptitude_questions = $query->select(
        'aptitude_question.*',
        'aptitude_choices.id as choice_id',
        'aptitude_choices.choices as choices',
        'aptitude_choices.is_correct'
    )
    ->orderByRaw('RAND()')
    ->get();

	// dd($aptitude_questions);

    // Check if there are no questions for the classification_id (and classification_level_id if applicable)
    if ($aptitude_questions->isEmpty()) {
        return view('student.aptitude_test', [
            'questions' => [],
            'current_question_index' => 0,
            'total_questions' => 0,
            'hasResults' => $hasResults,
            'no_questions' => true // Flag to indicate no questions
        ]);
    }

    $questions = [];
    foreach ($aptitude_questions as $item) {
        $question_id = $item->id;
        if (!isset($questions[$question_id])) {
            $questions[$question_id] = [
                'id' => $item->id,
                'question' => $item->question,
                'choices' => [],
            ];
        }
        $questions[$question_id]['choices'][] = [
            'id' => $item->choice_id,
            'choice' => $item->choices,
            'is_correct' => $item->is_correct,
        ];
    }
    $questions = array_values($questions);

    // Store questions in session to maintain order
    if (!session()->has('aptitude_questions')) {
        session(['aptitude_questions' => $questions]);
    } else {
        $questions = session('aptitude_questions');
    }

    $current_question_index = (int) $request->query('question', 0);
    $test_started = $request->query('start', false);

    if (!$test_started) {
        return view('student.aptitude_test_intro', [
            'total_questions' => count($questions),
            'hasResults' => $hasResults,
        ]);
    }

    if ($current_question_index < 0 || $current_question_index >= count($questions)) {
        $current_question_index = 0;
    }

    return view('student.aptitude_test', [
        'questions' => $questions,
        'current_question_index' => $current_question_index,
        'total_questions' => count($questions),
        'hasResults' => $hasResults,
        'no_questions' => false // Flag to indicate questions exist
    ]);
}

    public function saveAnswer(Request $request)
    {
		$answers = session('answers', []);
		$answers[$request->question_id] = $request->answer;
		session(['answers' => $answers]);
	
		return response()->json(['success' => true]);
    }

    public function getAnswers(Request $request)
    {
        return response()->json([
            'answers' => session('answers', [])
        ]);
    }

	public function aptitudeSubmit(Request $request)
{
    try {
        $gen_user = Auth::user()->person_id;
        $user = Student::findOrFail($gen_user);
        $answers = $request->answers;
        $questions = session('aptitude_questions', []);

        if (empty($answers) || empty($questions)) {
            return response()->json([
                'success' => false,
                'message' => 'No answers or questions found.'
            ], 400);
        }

        // Validate that all questions have been answered
        if (count($answers) < count($questions)) {
            return response()->json([
                'success' => false,
                'message' => 'Please answer all questions before submitting.'
            ], 400);
        }

        foreach ($questions as $question) {
            $questionId = $question['id'];
            $answerId = $answers[$questionId] ? : null;

            if (!$answerId) {
                continue; // Skip if no answer provided (optional: you could enforce all answers here)
            }

            $selectedChoice = DB::table('aptitude_choices')
                ->where('id', $answerId)
                ->where('question_id', $questionId)
                ->first();

            if ($selectedChoice) {
                AptitudeResults::create([
                    'student_id' => $user->id,
                    'question_id' => $questionId,
                    'answer_id' => $answerId,
                    'is_correct' => $selectedChoice->is_correct == 1,
                    'question_text' => $question['question'], // Optional
                    'answer_text' => $selectedChoice->choices, // Optional
                ]);
            }
        }

        // Clear session data after successful submission
        session()->forget(['answers', 'aptitude_questions']);

        return response()->json([
            'success' => true,
            'message' => 'Test submitted successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error saving answers: ' . $e->getMessage()
        ], 500);
    }
}

// 	public function aptitudeResults(Request $request)
// {
//     $gen_user = Auth::user()->person_id;
//     $user = Student::find($gen_user);
// 	$classification_id = $user->classification_id;
//     $classification_level_id = $user->classification_level_id;
//     // Fetch the user's test results
//     $results = AptitudeResults::where('student_id', $user->id)
//         ->join('aptitude_question', 'aptitude_results.question_id', '=', 'aptitude_question.id')
//         ->join('aptitude_choices as user_answer', 'aptitude_results.answer_id', '=', 'user_answer.id')
//         ->leftJoin('aptitude_choices as correct_answer', function ($join) {
//             $join->on('aptitude_results.question_id', '=', 'correct_answer.question_id')
//                  ->where('correct_answer.is_correct', '=', 1); // Added the operator '='
//         })
//         ->select(
//             'aptitude_question.question',
//             'user_answer.choices as user_answer',
//             'correct_answer.choices as correct_answer',
//             'aptitude_results.is_correct'
//         )
//         ->orderBy('aptitude_results.created_at', 'asc')
//         ->get();

//     if ($results->isEmpty()) {
//         return redirect()->route('aptitude.test')->with('error', 'You have not completed the test yet.');
//     }

//     $totalQuestions = $results->count();
//     $correctAnswers = $results->where('is_correct', 1)->count();
//     $incorrectAnswers = $totalQuestions - $correctAnswers;
//     $scorePercentage = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

//     return view('student.aptitude_test_results', [
//         'results' => $results,
//         'totalQuestions' => $totalQuestions,
//         'correctAnswers' => $correctAnswers,
//         'incorrectAnswers' => $incorrectAnswers,
//         'scorePercentage' => $scorePercentage,
//     ]);
// }

public function aptitudeResults(Request $request)
{
    $gen_user = Auth::user()->person_id;
    $user = Student::find($gen_user);
    $classification_id = $user->classification_id;
    $classification_level_id = $user->classification_level_id;

    // Fetch the user's test results
    $results = AptitudeResults::where('student_id', $user->id)
        ->join('aptitude_question', 'aptitude_results.question_id', '=', 'aptitude_question.id')
        ->join('aptitude_choices as user_answer', 'aptitude_results.answer_id', '=', 'user_answer.id')
        ->leftJoin('aptitude_choices as correct_answer', function ($join) {
            $join->on('aptitude_results.question_id', '=', 'correct_answer.question_id')
                 ->where('correct_answer.is_correct', '=', 1);
        })
        ->select(
            'aptitude_question.question',
            'user_answer.choices as user_answer',
            'correct_answer.choices as correct_answer',
            'aptitude_results.is_correct'
        )
        ->orderBy('aptitude_results.created_at', 'asc')
        ->get();

    if ($results->isEmpty()) {
        return redirect()->route('aptitude.test')->with('error', 'You have not completed the test yet.');
    }

    $totalQuestions = $results->count();
    $correctAnswers = $results->where('is_correct', 1)->count();
    $incorrectAnswers = $totalQuestions - $correctAnswers;
    $scorePercentage = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

    // Determine feedback based on classification_id and classification_level_id
    $feedback = $this->getFeedback($scorePercentage, $classification_id, $classification_level_id);

    return view('student.aptitude_test_results', [
        'results' => $results,
        'totalQuestions' => $totalQuestions,
        'correctAnswers' => $correctAnswers,
        'incorrectAnswers' => $incorrectAnswers,
        'scorePercentage' => $scorePercentage,
        'feedback' => $feedback,
    ]);
}

/**
 * Helper method to determine feedback based on score, classification_id, and classification_level_id
 */
private function getFeedback($scorePercentage, $classification_id, $classification_level_id)
{
    // Classification_id = 1
    if ($classification_id == 1) {
        if (in_array($classification_level_id, [1, 2, 3])) {
            if ($scorePercentage >= 90) {
                return "Excellent; strong foundational grasp";
            } elseif ($scorePercentage >= 70) {
                return "Good; growing core skills";
            } elseif ($scorePercentage >= 50) {
                return "Needs help; review basic understanding";
            } else {
                return "Struggling; intensive support needed";
            }
        } elseif (in_array($classification_level_id, [4, 5, 6])) {
            if ($scorePercentage >= 90) {
                return "Advanced; ready for higher challenges";
            } elseif ($scorePercentage >= 70) {
                return "On track; age-appropriate skills";
            } elseif ($scorePercentage >= 50) {
                return "Needs support; improve basic concepts";
            } else {
                return "Below level; focused help needed";
            }
        }
    }

    // Classification_id = 2
    if ($classification_id == 2) {
        if (in_array($classification_level_id, [7, 8])) {
            if ($scorePercentage >= 90) {
                return "Excellent; shows high aptitude";
            } elseif ($scorePercentage >= 70) {
                return "Good; stable performance";
            } elseif ($scorePercentage >= 50) {
                return "Average; needs reinforcement in skills";
            } else {
                return "Struggling; foundational support required";
            }
        } elseif (in_array($classification_level_id, [9, 10])) {
            if ($scorePercentage >= 90) {
                return "Strong; well-prepared for upper high school";
            } elseif ($scorePercentage >= 70) {
                return "Solid; good understanding of concepts";
            } elseif ($scorePercentage >= 50) {
                return "Fair; needs more practice in problem solving";
            } else {
                return "Learning gaps present; tutoring recommended";
            }
        }
    }

    // Classification_id = 11, 12
    if (in_array($classification_id, [11, 12])) {
        if ($scorePercentage >= 90) {
            return "Advanced; handles complex tasks effectively";
        } elseif ($scorePercentage >= 70) {
            return "Proficient; prepared for academic progression";
        } elseif ($scorePercentage >= 50) {
            return "Developing; requires academic support";
        } else {
            return "At risk; needs intervention and review";
        }
    }

    // Classification_id = 13, 14, 15
    if (in_array($classification_id, [13, 14, 15])) {
        if ($scorePercentage >= 90) {
            return "Excellent aptitude; ready for higher academics or employment";
        } elseif ($scorePercentage >= 70) {
            return "Above average; minor improvements needed";
        } elseif ($scorePercentage >= 50) {
            return "Average; needs reinforcement in math or logic";
        } else {
            return "Weak aptitude; core concepts need review";
        }
    }

    // Default feedback if no specific match
    return "Score: " . number_format($scorePercentage, 2) . "% - Please consult your instructor for feedback.";
}

	public function chatBot(Request $request)
	{
		session_start(); // Start a session to store conversation state
	
		$question = strtolower(trim($request->input('question')));
		$conversation_state = isset($_SESSION['chat_state']) ? $_SESSION['chat_state'] : '';
	
		// Predefined responses
		$responses = [
			"hello" => "Hi there! How can I help you?",
			"who are you" => "I am a chatbot for GOLink.",
			'family problem' => [
				"I'm really sorry to hear that. Do you want to talk about what's been bothering you?",
				"That sounds really stressful. Have you tried talking to someone you trust, like a teacher or counselor?",
				"It's okay to feel overwhelmed. Sometimes writing down your feelings before talking to someone can help.",
				"Would you like some advice on how to express your feelings to someone who can help?"
			],
			'stress' => [
				"Feeling stressed with school or work is common. Would you like some study tips or relaxation techniques? (Yes/No)",
			],
			'yes' => [
				"Great! Would you prefer study tips or relaxation techniques?",
			],
			'no' => [
				"That's okay! If you ever need advice, feel free to ask. Take care!",
			],
			'study tips' => [
				"Here are some study tips:  
				📌 Break tasks into small, manageable parts.  
				⏳ Use the Pomodoro technique (25 min study, 5 min break).  
				📝 Make a study schedule and stick to it.  
				🎧 Try listening to instrumental music while studying.  
				✍️ Take notes in your own words for better understanding.",
			],
			'relaxation techniques' => [
				"Here are some relaxation techniques:  
				🌿 Try deep breathing exercises – inhale for 4 seconds, hold for 4, exhale for 4.  
				🧘 Practice mindfulness or meditation.  
				🚶 Take a short walk or stretch to clear your mind.  
				🎶 Listen to calming music or nature sounds.  
				☕ Drink a warm tea and take a moment to breathe."
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
		if ($conversation_state === 'stress') {
			$_SESSION['chat_state'] = ''; // Reset state after response
			$answer = "Would you like some study tips or relaxation techniques? (Yes/No)";
		} elseif ($conversation_state === 'yes') {
			$_SESSION['chat_state'] = ''; // Reset state
			$answer = "Would you prefer study tips or relaxation techniques?";
		} elseif ($conversation_state === 'no') {
			$_SESSION['chat_state'] = ''; // Reset state
			$answer = "That's okay! If you ever need advice, feel free to ask. Take care!";
		} else {
			foreach ($responses as $keyword => $responseArray) {
				if (strpos($question, $keyword) !== false) {
					$_SESSION['chat_state'] = $keyword; // Store conversation state
					
					// Check if response is an array or a single string
					if (is_array($responseArray)) {
						$answer = $responseArray[array_rand($responseArray)];
					} else {
						$answer = $responseArray;
					}
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
		$password = \Request::input('password');
		$confirm_password = \Request::input('confirm_password');


		
		$gen_user = Auth::user()->person_id;
		$person = Person::find($gen_user);

		if ($person) {
			$person->update([
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
		}

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
		$user = User::where('person_id', $person->id)->first();
		if ($user) {
			$user->update([
				'is_new' => 0,
				'password' => \Illuminate\Support\Facades\Hash::make($password)
			]);
		} 
		
		return response()->json(['success' => true, 'person' => $person,'family_background' => $family_background, 'educational_background' => $educational_background, 'other_survey' => $other_survey, 'survey' => $survey]);
		
	}

	public function update_pds()
	{
		$person_id = \Request::input('person_id');
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


		$person = Person::updateOrCreate(
			['id' => \Request::input('person_id')],
			[
				'first_name' => \Request::input('first_name'),
				'last_name' => \Request::input('last_name'),
				'email_address' => \Request::input('student_email'),
				'middle_name' => \Request::input('middle_name'),
				'date_input' => \Request::input('today_date'),
				'gender_id' => \Request::input('gender_id'),
				'civil_status_id' => \Request::input('civil_status_id'),
				'citizenship_id' => \Request::input('citizenship_id'),
				'mobile_number' => \Request::input('student_mobile_no'),
				'address' => \Request::input('address'),
				'place_of_birth' => \Request::input('place_of_birth'),
				'religion_id' => \Request::input('religion_id'),
				'birthdate' => \Request::input('birthdate'),
				'incase_of_emergency' => \Request::input('emergency_contact'),
			]
		);

		$family_background = FamilyBackground::updateOrCreate(
			['person_id' => $person->id],
			[
				'no_brother' => \Request::input('no_bro'),
				'no_sister' => \Request::input('no_sis'),
				'father_name' => \Request::input('father_name'),
				'mother_name' => \Request::input('mother_name'),
				'father_age' => \Request::input('father_age'),
				'mother_age' => \Request::input('mother_age'),
				'father_address' => \Request::input('father_address'),
				'mother_address' => \Request::input('mother_address'),
				'father_educational' => \Request::input('father_educational'),
				'mother_educational' => \Request::input('mother_educational'),
				'father_occupation' => \Request::input('father_occupation'),
				'mother_occupation' => \Request::input('mother_occupation'),
				'father_mobile' => \Request::input('father_number'),
				'mother_mobile' => \Request::input('mother_number')
			]
		);

		$survey = Survey::updateOrCreate(
			['person_id' => $person->id],
			[
				'working_student' => \Request::input('workingStudent'),
				'scholar' => \Request::input('scholar'),
				'single_parent' => \Request::input('singleParent'),
				'guardian' => \Request::input('who_guardian'),
				'sponsor' => \Request::input('who_sponsor'),
				'children' => \Request::input('many_children'),
				'married' => \Request::input('married'),
			]
		);


		$educational_background = EducationalBackground::updateOrCreate(
			['person_id' => $person->id],
			[
				'elem_school' => \Request::input('elem'),
				'elem_subject_like' => \Request::input('elem_sub_like'),
				'elem_subject_not_like' => \Request::input('elem_sub_not_like'),
				'jhs_school' => \Request::input('jhs'),
				'jhs_subject_like' => \Request::input('jhs_sub_like'),
				'jhs_subject_not_like' => \Request::input('jhs_sub_not_like'),
				'g11_school' => \Request::input('g11'),
				'g11_subject_like' => \Request::input('g11_sub_like'),
				'g11_subject_not_like' => \Request::input('g11_sub_not_like'),
				'g12_school' => \Request::input('g12'),
				'g12_subject_like' => \Request::input('g12_sub_like'),
				'g12_subject_not_like' => \Request::input('g12_sub_not_like'),
				'college_school' => \Request::input('college'),
				'college_subject_like' => \Request::input('college_sub_like'),
				'college_subject_not_like' => \Request::input('college_sub_not_like'),
			]
		);
	
		$other_survey = OtherSurvey::updateOrCreate(
			['person_id' => $person->id],
			[
				'easiest_sub' => \Request::input('easiest'),
				'most_difficult_sub' => \Request::input('most_diff_sub'),
				'sub_with_lowest' => \Request::input('subj_lowest'),
				'sub_with_highest' => \Request::input('subj_highest_grade'),
				'plan_after_hs' => \Request::input('plan_after_hs'),
				'awards' => \Request::input('award'),
			]
		);
	
		return response()->json(['success' => true, 'person' => $person,'family_background' => $family_background, 'educational_background' => $educational_background, 'other_survey' => $other_survey, 'survey' => $survey]);
	}

	public function saveConversation(Request $request)
    {
        // Validate the incoming request
       
        // Save the conversation to the database
		
	

        $conversation = new ChatbotConversation();
        $conversation->response = $request->input('response');
		$conversation->user_id = Auth::id();
        $conversation->save();

        return response()->json(['success' => 'Conversation saved successfully.']);
    }

	public function createStudent()
	{
		$first_name = \Request::input('first_name');
		$middle_name = \Request::input('middle_name');
		$last_name = \Request::input('last_name');
		$email = \Request::input('email');
		$student_no = \Request::input('student_no');
		$classification_id = \Request::input('classification_id');
		$school_department_id = \Request::input('school_department_id');
		$classification_level_id = \Request::input('classification_level_id');
		$password = \Request::input('password');
		$role = \Request::input('role');


		$person = new Person();
		$person->first_name = $first_name;
		$person->middle_name = $middle_name;
		$person->last_name = $last_name;
		$person->save();
		$student = Student::firstOrCreate([
			'person_id' => $person->id,
		]);
		$student->student_no = $student_no;
		$student->classification_id = $classification_id;
		$student->school_department_id = $school_department_id;
		$student->classification_level_id = $classification_level_id;
		$student->save();

		$user = User::firstOrCreate([
			'person_id' => $person->id,
		]);
		$user->name = $first_name;
		$user->email = $email;
		$user->student_no = $student_no;
		$user->password = Hash::make($password);
		$user->role = $role;
		$user->is_new = 1;
		$user->save();
		return response()->json([
			'success' => true,
			'message' => 'Student created successfully.',
		], 200);
	}


	public function getClassificationLevel($classification_id)
    {
		$classificationLevels = ClassificationLevel::where('classification_id', $classification_id)->get();
		$school_departments = SchoolDepartment::where('classification_id', $classification_id)->get();
        return response()->json([
            'classification_levels' => $classificationLevels,
            'school_departments' => $school_departments
        ]);
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

		// dd($request->all());
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
