<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Person;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Input;
use Redirect;
use Illuminate\Support\Str;
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

	// public function uploadImageStudent(Request $request)
    // {
    //     try {
    //         if (!$request->hasFile('file')) {
    //             return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
    //         }

    //         $file = $request->file('file');
    //         $extension = $file->getClientOriginalExtension();

    //         // Generate a unique filename
    //         $uniqueId = time() . '_' . Str::random(10);
    //         $newFilename = $uniqueId . '.' . $extension;
    //         $destinationPath = public_path('assets/img/profile');

    //         // Ensure directory exists
    //         if (!file_exists($destinationPath)) {
    //             mkdir($destinationPath, 0777, true);
    //         }

    //         // Move file to destination
    //         $file->move($destinationPath, $newFilename);

    //         // Update authenticated user's person record
    //         $user = Auth::user();
    //         if ($user && $user->person_id) {
    //             $person = Person::find($user->person_id);
    //             if ($person) {
    //                 $imagePath = "assets/img/profile/" . $newFilename;
    //                 $person->img = $imagePath;
    //                 $person->save();
    //             } else {
    //                 return response()->json(['success' => false, 'message' => 'Person record not found'], 404);
    //             }
    //         } else {
    //             return response()->json(['success' => false, 'message' => 'User not authenticated or no person_id'], 401);
    //         }

    //         // Return the image path in the response
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'File uploaded successfully',
    //             'image_path' => $imagePath
    //         ]);
    //     } catch (\Exception $e) {
    //         \Log::error('Upload error: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Upload failed'], 500);
    //     }
    // }

	public function uploadImageStudent(Request $request)
{
    try {
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $personId = $request->input('person_id');

        // Generate a unique filename
        $uniqueId = time() . '_' . Str::random(10);
        $newFilename = $uniqueId . '.' . $extension;
        $destinationPath = public_path('assets/img/profile');

        // Ensure directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Move file to destination
        $file->move($destinationPath, $newFilename);
        $imagePath = "assets/img/profile/" . $newFilename;

        // Handle Person record
        if ($personId) {
            // Existing record: Update the image
            $person = Person::find($personId);
            if (!$person) {
                return response()->json(['success' => false, 'message' => 'Person record not found'], 404);
            }

            // Delete old image if it exists
            if ($person->img && file_exists(public_path($person->img))) {
                unlink(public_path($person->img));
            }

            $person->img = $imagePath;
            $person->save();
        } else {
            // New record: Create a new Person record
            $person = new Person();
            $person->img = $imagePath;
            $person->save();
            $personId = $person->id; // Get the new person_id
        }

        // Return the image path and person_id in the response
        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully',
            'image_path' => $imagePath,
            'person_id' => $personId
        ]);
    } catch (\Exception $e) {
        \Log::error('Upload error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Upload failed'], 500);
    }
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
