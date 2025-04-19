<?php namespace App\Http\Controllers;

use App\Anecdotal;
use App\AptitudeResults;
use App\ChatbotConversation;
use App\Citizenship;
use App\CivilStatus;
use App\Classification;
use App\Counseling;
use App\Psychology;
use App\EducationalBackground;
use App\FamilyBackground;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\OtherSurvey;
use App\Person;
use App\Religion;
use App\Student;
use App\Survey;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Input;
use Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$classification_list = Classification::all();

		return view('admin.index',compact('classification_list'));
	}

	public function getStudentPds(Request $request)
		{
			$classification_id = $request->classification_id;
			$classification_level_id = $request->classification_level_id;

			$query = Student::join('person', 'student.person_id', '=', 'person.id')
				->join('classification', 'student.classification_id', '=', 'classification.id')
				->join('classification_level', 'student.classification_level_id', '=', 'classification_level.id')
				->orderBy('person.last_name', 'asc')
				->select('person.id as person_id', 'first_name', 'middle_name', 'last_name','classification.classification_name','classification_level.level')
				->where(function($query) use($classification_id, $classification_level_id) {
					if($classification_id != "") {
						$query->where("student.classification_id", $classification_id);
					} 
					
					if($classification_level_id != "") {
						$query->where("student.classification_level_id", $classification_level_id);
					} 
				});

			$students = $query->get();
	
			$datatable = $students->map(function ($student) {
				$fullName = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
				return [
					'name' => '<a data-person_id="'.$student->person_id.'" title="Click to view details" 
								style="text-decoration: underline; cursor: pointer; color: #4620b1 !important;" 
								class="viewDetail">'.$fullName.'</a>',
					'classification' => $student->classification_name,
					'level' => $student->level,
					'pdf' => '<a data-person_id="'.$student->person_id.'" title="Click to view details" 
							style="text-decoration: underline; cursor: pointer; color: #4620b1 !important;" 
							class="viewDetailPDF">PDF</a>',
				];
			});

			return response()->json($datatable);
		}


		public function anecDotalDataSheet(Request $request){
			$classification_id = $request->classification_id;
			$classification_level_id = $request->classification_level_id;

			$query = Student::join('person', 'student.person_id', '=', 'person.id')
				->join('classification', 'student.classification_id', '=', 'classification.id')
				->join('classification_level', 'student.classification_level_id', '=', 'classification_level.id')
				->leftjoin('anecdotal','student.id', '=', 'anecdotal.student_id')
				->orderBy('person.last_name', 'asc')
				->select('person.id as person_id', 'first_name', 'middle_name', 'last_name','classification.classification_name','classification_level.level','anecdotal.img','anecdotal.summary')
				->where(function($query) use($classification_id, $classification_level_id) {
					if($classification_id != "") {
						$query->where("student.classification_id", $classification_id);
					} 
					
					if($classification_level_id != "") {
						$query->where("student.classification_level_id", $classification_level_id);
					} 
				});

			$students = $query->get();
		

			$datatable = $students->map(function ($student) {
				$fullName = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
				
				$imagePath = url($student->img);
				return [
					'name' => '<a data-person_id="'.$student->person_id.'" title="Click to view details" 
								style="text-decoration: underline; cursor: pointer; color: #4620b1 !important;" 
								class="viewDetail">'.$fullName.'</a>',
					'classification' => $student->classification_name,
					'level' => $student->level,
					'img' => $student->img ? '<a href="#" class="viewImage" data-img="'.$imagePath.'">'.basename($student->img).'</a>' : '',
					'summary' => $student->summary,
				];
			});

			return response()->json($datatable);
		}

		public function chatBotData(Request $request)
		{
			$person_id = $request->get('person_id');
			
			// Fetch conversation data
			$query = ChatbotConversation::join('users', 'chatbot.user_id', '=', 'users.id')
				->join('person', 'users.person_id', '=', 'person.id')
				->where('person.id', $person_id)
				->where('chatbot.response', '!=', "Hello! I'm GOLink, your **AI Agent** here to help with school concerns. How can I assist you?")
				->orderBy('chatbot.created_at', 'asc')
				->select(
					'person.id as person_id',
					'first_name',
					'middle_name',
					'last_name',
					'chatbot.response',
					'chatbot.created_at'
				);
	
			$conversationsRaw = $query->get();
	
			// Structure conversation data (replace flatMap)
			$conversations = [];
			foreach ($conversationsRaw as $item) {
				$fullName = trim($item->first_name . ' ' . $item->middle_name . ' ' . $item->last_name);
				$timestamp = $item->created_at->format('F j Y');
				
				// Add student message if it exists
				if (!empty($item->response)) {
					$conversations[] = [
						'type' => 'student',
						'message' => $item->response,
						'sender' => $fullName,
						'timestamp' => $timestamp,
					];
				}
				
				// Add AI response if it exists
				if (!empty($item->response)) {
					$conversations[] = [
						'type' => 'ai',
						'message' => $item->response,
						'sender' => 'GOLink AI',
						'timestamp' => $timestamp,
					];
				}
			}
	
			return view('admin.chatbot', compact('conversations'));
		}

		public function getStudentProfilePdf()
		{

			$person_id = \Request::get('person_id');


			$student_details = Person::leftJoin('gender', 'person.gender_id', '=', 'gender.id')
			->leftjoin('civil_status','person.civil_status_id', '=', 'civil_status.id')
			->leftjoin('religion','person.religion_id', '=', 'religion.id')
			->leftjoin('citizenship','person.citizenship_id', '=', 'citizenship.id')
			->leftjoin('survey','person.id','=','survey.person_id')
			->leftJoin('family_background', 'person.id', '=', 'family_background.person_id')
			->leftjoin('educational_background','person.id','=','educational_background.person_id')
			->leftjoin('other_survey','person.id','=','other_survey.person_id')
			->where('person.id', $person_id)
			->select('person.*', 'gender.id as gender_id','civil_status.civil_status_name','religion.religion_name','citizenship.citizenship_name','survey.working_student','survey.scholar','survey.single_parent','survey.guardian','survey.sponsor','survey.married','survey.children','family_background.no_brother','family_background.no_sister','family_background.father_name','family_background.mother_name','family_background.father_age','family_background.mother_age','family_background.father_address','family_background.mother_address','family_background.father_educational','family_background.mother_educational','family_background.father_occupation','family_background.mother_occupation','family_background.father_mobile','family_background.mother_mobile','educational_background.elem_school','educational_background.elem_subject_like','educational_background.elem_subject_not_like','educational_background.jhs_subject_like','educational_background.jhs_subject_not_like','educational_background.g11_school','educational_background.g11_subject_like','educational_background.g11_subject_not_like','educational_background.g12_school','educational_background.g12_subject_like','educational_background.g12_subject_not_like','educational_background.college_school','educational_background.college_subject_like','educational_background.college_subject_not_like','other_survey.easiest_sub','other_survey.most_difficult_sub','other_survey.sub_with_lowest','other_survey.sub_with_highest','other_survey.plan_after_hs','other_survey.awards','person.incase_of_emergency') 
			->first();
			// dd($person_id);


			$pdf = \PDF::loadView('admin.student_pdf',compact('student_details'));
	
			$pdf->setPaper('legal', 'portrait');
			return $pdf->stream('student_pdf.pdf');
		}


	public function getStudentProfile()
	{
		$person_id = \Request::get('person_id');

		$person = Person::find($person_id);

		$religion_list = Religion::all();
		$citizenship_list = Citizenship::all();
		$civil_status_list = CivilStatus::all();

		$famiy_background = FamilyBackground::where('person_id', $person->id)->first();
		$education_background = EducationalBackground::where('person_id', $person->id)->first();
		$survey = Survey::where('person_id', $person->id)->first();
		$other_survey = OtherSurvey::where('person_id', $person->id)->first();
		// dd($person_id);



		return view('admin.student_pds',compact('religion_list','citizenship_list','civil_status_list','person','famiy_background','education_background','other_survey','survey','person_id'));
	}

	public function import(){
		return view('admin.import');
	}
	public function importExcel(Request $request)
	{
		if (!$request->hasFile('excelFile')) {
			return response()->json([
				'status' => 'error',
				'message' => 'No file uploaded'
			], 400);
		}
	
		$file = $request->file('excelFile');
		ini_set('max_execution_time', 0);
	
		try {
			Excel::load($file, function ($reader) {
				$data_arr = $reader->get()->toArray();
	
				foreach ($data_arr as $data) {
					
					$person_details = new Person();
					$person_details->last_name = $data['last_name'];
					$person_details->first_name = $data['first_name'];
					$person_details->middle_name = $data['middle_name'];
					$person_details->birthdate = $data['birthdate'];
					
					$gender = strtoupper(trim($data['gender']));
					$person_details->gender_id = ($gender === 'MALE') ? 1 : (($gender === 'FEMALE') ? 2 : null);
					$person_details->save();
	
		
					$student_details = Student::firstOrCreate(
						['person_id' => $person_details->id]
					);
					$student_details->student_no = $data['student_no'];
					$student_details->classification_id = $data['classification_id'];
					$student_details->classification_level_id = $data['classification_level_id'];
					$student_details->school_department_id = $data['school_department_id'];
					$student_details->save();
	
					$gen_user_details = User::firstOrCreate(
						['person_id' => $person_details->id]
					);

					$gen_user_details->student_no = 'ascb-' . $data['student_no'];
					$gen_user_details->email = 'ascb-' . $data['student_no'];
					$gen_user_details->password = Hash::make('ascb-' . $data['student_no']);
					$gen_user_details->role = 'student';
					$gen_user_details->is_new = 1;
					$gen_user_details->save();
				}
			});
	
			return response()->json([
				'status' => 'success',
				'message' => 'Data imported successfully'
			]);
	
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'error',
				'message' => 'Import failed: ' . $e->getMessage()
			], 500);
		}
	}
	public function importPostExcel()
    {
        if(\Request::hasFile('excelFile')) {
            $file = \Request::file('excelFile');
            $data_arr = [];
            $column_arr = [];
            \Excel::load($file, function($reader) use(&$data_arr, &$column_arr) {
                $data_arr[] = $reader->get()->toArray();
                $column_arr = count($reader->get()->toArray()) > 0 ? str_replace("_"," ", array_keys($reader->get()->toArray()[0])) : [];
            });
            
            $columns = [];
            foreach($column_arr as $column) {
                $columns[str_replace(" ","_",$column)] = mb_convert_case($column, MB_CASE_TITLE, "UTF-8");
            }
                
            return response()->json(['data' => $data_arr, 'columns' => $columns]);
        }
    } 


	public function chatBot(){
		return view('admin.chatbot');
	}

	public function anecDotal()
	{

		$classification_list = Classification::all();

		return view('admin.anecdotal',compact('classification_list'));
	}

	public function anecdotalData(){
		return view('admin.anecdotalData');
	}

	public function counselingData()
	{
		return view('admin.counselingData');
	}

	public function psychologyData()
	{
	
	$person_id = \Request::get('person_id');
    $user = Student::where('id',$person_id)->first();
    $classification_id = $user->classification_id;
    $classification_level_id = $user->classification_level_id;
	// dd($person_id);
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
			return view('admin.psychologyData', [
				'results' => $results,
				'message' => 'This student has not yet taken the aptitude test.',
				'totalQuestions' => 0,
				'correctAnswers' => 0,
				'incorrectAnswers' => 0,
				'scorePercentage' => 0,
				'feedback' => 'No feedback available. Please take the test first.',
			]);
		}

    $totalQuestions = $results->count();
    $correctAnswers = $results->where('is_correct', 1)->count();
    $incorrectAnswers = $totalQuestions - $correctAnswers;
    $scorePercentage = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

    // Determine feedback based on classification_id and classification_level_id
    $feedback = $this->getFeedback($scorePercentage, $classification_id, $classification_level_id);

    return view('admin.psychologyData', [
        'results' => $results,
        'totalQuestions' => $totalQuestions,
        'correctAnswers' => $correctAnswers,
        'incorrectAnswers' => $incorrectAnswers,
        'scorePercentage' => $scorePercentage,
        'feedback' => $feedback,
    ]);




		// return view('admin.psychologyData');
	}

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


	public function uploadImageAnecdotal()
	{
		$files = Input::file('files');
		$person_id = Input::get('person_id');
		$person = Person::find($person_id);

		\Log::info('Files received: ', ['files' => $files, 'person_id' => $person_id]);

		if (!$files || !$person) {
			\Log::error('No files uploaded or missing person ID.');
			return Redirect::to('upload_image_file')->with('error', 'No files uploaded or person ID not found.');
		}

		$destination_path = 'assets/site/images/anecdotal/'; // Upload path

		foreach ($files as $file) {
			if (!$file->isValid()) {
				\Log::error("Invalid file uploaded by person_id: $person_id");
				continue;
			}

			$extension = $file->getClientOriginalExtension(); // Get file extension
			$newFilename = $person->person_id . '_' . str_replace(' ', '_', $person->last_name) . '.' . $extension; // Rename using person_id

			$file->move(public_path($destination_path), $newFilename);

			$student = Student::where('person_id',$person_id)->first();

			$anecdotal = Anecdotal::firstOrCreate(['student_id' => $student->id]);
			$anecdotal->img = "assets/site/images/anecdotal/". $newFilename;
			$anecdotal->save();
		}

		Session::flash('success', 'Files uploaded successfully.');
		\Log::info("Files uploaded successfully for person_id: $person_id");

		return Redirect::to('admin/anecdotal_data')->with('success', 'Files uploaded successfully.');
	}

	public function uploadImageCounseling()
	{
		$files = Input::file('files');
		$person_id = Input::get('person_id');
		$person = Person::find($person_id);

		\Log::info('Files received: ', ['files' => $files, 'person_id' => $person_id]);

		if (!$files || !$person) {
			\Log::error('No files uploaded or missing person ID.');
			return Redirect::to('upload_image_file')->with('error', 'No files uploaded or person ID not found.');
		}

		$destination_path = 'assets/site/images/counseling/'; // Upload path

		foreach ($files as $file) {
			if (!$file->isValid()) {
				\Log::error("Invalid file uploaded by person_id: $person_id");
				continue;
			}

			$extension = $file->getClientOriginalExtension(); // Get file extension
			$newFilename = $person->person_id . '_' . str_replace(' ', '_', $person->last_name) . '.' . $extension; // Rename using person_id

			$file->move(public_path($destination_path), $newFilename);

			$student = Student::where('person_id',$person_id)->first();

			$anecdotal = Counseling::firstOrCreate(['student_id' => $student->id]);
			$anecdotal->img = "assets/site/images/counseling/". $newFilename;
			$anecdotal->save();
		}

		Session::flash('success', 'Files uploaded successfully.');
		\Log::info("Files uploaded successfully for person_id: $person_id");

		return Redirect::to('admin/counseling_data')->with('success', 'Files uploaded successfully.');
	}

	public function uploadImagePsychology()
	{
		$files = Input::file('files');
		$person_id = Input::get('person_id');
		$person = Person::find($person_id);

		\Log::info('Files received: ', ['files' => $files, 'person_id' => $person_id]);

		if (!$files || !$person) {
			\Log::error('No files uploaded or missing person ID.');
			return Redirect::to('upload_image_file')->with('error', 'No files uploaded or person ID not found.');
		}

		$destination_path = 'assets/site/images/psychology/'; // Upload path

		foreach ($files as $file) {
			if (!$file->isValid()) {
				\Log::error("Invalid file uploaded by person_id: $person_id");
				continue;
			}

			$extension = $file->getClientOriginalExtension(); // Get file extension
			$newFilename = $person->person_id . '_' . str_replace(' ', '_', $person->last_name) . '.' . $extension; // Rename using person_id

			$file->move(public_path($destination_path), $newFilename);

			$student = Student::where('person_id',$person_id)->first();

			$anecdotal = Psychology::firstOrCreate(['student_id' => $student->id]);
			$anecdotal->img = "assets/site/images/psychology/". $newFilename;
			$anecdotal->save();
		}

		Session::flash('success', 'Files uploaded successfully.');
		\Log::info("Files uploaded successfully for person_id: $person_id");

		return Redirect::to('admin/psychology_data')->with('success', 'Files uploaded successfully.');
	}

	public function anecdotalSummary()
	{
		$person_id = Input::get('person_id');
		$anecdotal_summary = Input::get('anecdotal_summary');

		$student = Student::where('person_id',$person_id)->first();
		$anecdotal = Anecdotal::firstOrCreate(['student_id' => $student->id]);
		$anecdotal->summary =$anecdotal_summary;
		$anecdotal->save();
		return response()->json(['success' => true, 'message' => 'Anecdotal summary saved successfully!']);
	}

	public function counselingSummary()
	{
		$person_id = Input::get('person_id');
		$counseling_summary = Input::get('counseling_summary');

		$student = Student::where('person_id',$person_id)->first();
		$anecdotal = Counseling::firstOrCreate(['student_id' => $student->id]);
		$anecdotal->summary =$counseling_summary;
		$anecdotal->save();
		return response()->json(['success' => true, 'message' => 'Counseling summary saved successfully!']);
	}

	public function psychologySummary()
	{
		$person_id = Input::get('person_id');
		$psychology_summary = Input::get('psychology_summary');

		$student = Student::where('person_id',$person_id)->first();
		$anecdotal = Psychology::firstOrCreate(['student_id' => $student->id]);
		$anecdotal->summary =$psychology_summary;
		$anecdotal->save();
		return response()->json(['success' => true, 'message' => 'Psychology summary saved successfully!']);
	}


	public function counseling()
	{
		$classification_list = Classification::all();

		return view('admin.counseling',compact('classification_list'));
	}

	public function psychology(){
		$classification_list = Classification::all();

		return view('admin.psychology',compact('classification_list'));
	}

	public function counselingDataSheet(Request $request){
		$classification_id = $request->classification_id;
		$classification_level_id = $request->classification_level_id;

		$query = Student::join('person', 'student.person_id', '=', 'person.id')
			->join('classification', 'student.classification_id', '=', 'classification.id')
			->join('classification_level', 'student.classification_level_id', '=', 'classification_level.id')
			->leftjoin('counseling','student.id', '=', 'counseling.student_id')
			->orderBy('person.last_name', 'asc')
			->select('person.id as person_id', 'first_name', 'middle_name', 'last_name','classification.classification_name','classification_level.level','counseling.img','counseling.summary')
			->where(function($query) use($classification_id, $classification_level_id) {
				if($classification_id != "") {
					$query->where("student.classification_id", $classification_id);
				} 
				
				if($classification_level_id != "") {
					$query->where("student.classification_level_id", $classification_level_id);
				} 
			});

		$students = $query->get();
	

		$datatable = $students->map(function ($student) {
			$fullName = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
			
			$imagePath = url($student->img);
			return [
				'name' => '<a data-person_id="'.$student->person_id.'" title="Click to view details" 
							style="text-decoration: underline; cursor: pointer; color: #4620b1 !important;" 
							class="viewDetail">'.$fullName.'</a>',
				'classification' => $student->classification_name,
				'level' => $student->level,
				//'img' => $student->img ? '<a href="#" class="viewImage" data-img="'.$imagePath.'">'.basename($student->img).'</a>' : '',
				//'summary' => $student->summary,
			];
		});

		return response()->json($datatable);
	}

	public function psychologyDataSheet(Request $request)
	{
		$classification_id = $request->classification_id;
		$classification_level_id = $request->classification_level_id;

		$query = Student::join('person', 'student.person_id', '=', 'person.id')
			->join('classification', 'student.classification_id', '=', 'classification.id')
			->join('classification_level', 'student.classification_level_id', '=', 'classification_level.id')
			->leftjoin('psychology','student.id', '=', 'psychology.student_id')
			->orderBy('person.last_name', 'asc')
			->select('person.id as person_id', 'first_name', 'middle_name', 'last_name','classification.classification_name','classification_level.level','psychology.img','psychology.summary')
			->where(function($query) use($classification_id, $classification_level_id) {
				if($classification_id != "") {
					$query->where("student.classification_id", $classification_id);
				} 
				
				if($classification_level_id != "") {
					$query->where("student.classification_level_id", $classification_level_id);
				} 
			});

		$students = $query->get();
	

		$datatable = $students->map(function ($student) {
			$fullName = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
			
			$imagePath = url($student->img);
			return [
				'name' => '<a data-person_id="'.$student->person_id.'" title="Click to view details" 
							style="text-decoration: underline; cursor: pointer; color: #4620b1 !important;" 
							class="viewDetail">'.$fullName.'</a>',
				'classification' => $student->classification_name,
				'level' => $student->level,
				'img' => $student->img ? '<a href="#" class="viewImage" data-img="'.$imagePath.'">'.basename($student->img).'</a>' : '',
				'summary' => $student->summary,
			];
		});

		return response()->json($datatable);
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
