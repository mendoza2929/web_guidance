<?php namespace App\Http\Controllers;

use App\Anecdotal;
use App\ChatbotConversation;
use App\Citizenship;
use App\CivilStatus;
use App\Classification;
use App\Counseling;
use App\EducationalBackground;
use App\FamilyBackground;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\OtherSurvey;
use App\Person;
use App\Religion;
use App\Student;
use App\Survey;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Input;
use Redirect;

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
					'level' => $student->level
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

		public function chatBotData()
		{
			$query = ChatbotConversation::join('users', 'chatbot.user_id', '=', 'users.id')
				->join('person', 'users.person_id', '=', 'person.id')
				->where('chatbot.response', '!=', "Hello! I'm GOLink, your **AI Agent** here to help with school concerns. How can I assist you?")
				->orderBy('chatbot.created_at', 'asc')
				->select('person.id as person_id', 'first_name', 'middle_name', 'last_name', 'chatbot.response');

			$students = $query->get();

			$datatable = $students->map(function ($student) {
				$fullName = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
				return [
					'name' => $fullName,
					'response' => $student->response,
				];
			});

			return response()->json($datatable);
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
		// dd($education_background);



		return view('admin.student_pds',compact('religion_list','citizenship_list','civil_status_list','person','famiy_background','education_background','other_survey','survey'));
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
		return response()->json(['success' => true, 'message' => 'Anecdotal summary saved successfully!']);
	}


	public function counseling()
	{
		$classification_list = Classification::all();

		return view('admin.counseling',compact('classification_list'));
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
