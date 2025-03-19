<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Person;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Input;
use Redirect;
class FileUploadController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('file_upload.index');
	}

	public function uploadImage()
	{
		$file = Input::file('files');

		\Log::info('Files received: ', ['files' => $file]);

		// Validate if files are present
		if (!$file) {
			\Log::info('No files uploaded');
			return Redirect::to('upload_image_file');  	

		}

		$files = $file;

		// Process each file
		$destination_path = 'assets/img/profile/'; // upload path

		foreach ($files as $file) {
			$originalFilename = $file->getClientOriginalName();
			$filenameWithoutExtension = pathinfo($originalFilename, PATHINFO_FILENAME);
			$extension = $file->getClientOriginalExtension();
			$cleanFilename = preg_replace('/[^A-Za-z0-9_\-]/', '', $filenameWithoutExtension);

			if (empty($cleanFilename)) {
				\Log::info('Invalid file name.');
			}

			$newFilename = $cleanFilename . '.' . $extension;
			$file->move($destination_path, $newFilename);

			// Save record to database
			$student = Student::where('student.student_no', $cleanFilename)->select('student.person_id')->first();

			if ($student) {
				$person = Person::find($student->person_id);
				$person->img = "assets/img/profile/". $newFilename;
				$person->save();
			}
		}

		Session::flash('success', 'Files uploaded successfully.');
		\Log::info('Files uploaded successfully.');

		return Redirect::to('upload_image_file');  

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
