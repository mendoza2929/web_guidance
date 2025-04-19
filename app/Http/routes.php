<?php


Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('/studentForm', 'StudentController@index');
Route::post('student/create_pds', 'StudentController@createPds');
Route::post('student/update_pds', 'StudentController@update_pds');


// routes/web.php
// routes/web.php
Route::get('aptitude-test', ['as' => 'aptitude.test', 'uses' => 'StudentController@aptitudeTest']);
Route::post('aptitude-test/save-answer', ['as' => 'aptitude.save-answer', 'uses' => 'StudentController@saveAnswer']);
Route::post('aptitude_submit', ['as' => 'aptitude.submit', 'uses' => 'StudentController@aptitudeSubmit']);
Route::get('aptitude-test/answers', ['as' => 'aptitude.get-answers', 'uses' => 'StudentController@getAnswers']);
Route::get('aptitude-test/results', ['as' => 'aptitude.results', 'uses' => 'StudentController@aptitudeResults']);
// Route::post

Route::post('student/studentFormSave', 'StuddentController@store');


Route::get('admin/student_pds', 'AdminController@getStudentPds');
Route::get('admin/student_profile', 'AdminController@getStudentProfile');
Route::get('admin/student_profile_pdf', 'AdminController@getStudentProfilePdf');

// anecdotal

Route::get('admin/anecdotal', 'AdminController@anecDotal');
Route::get('anecdotal/data_sheet', 'AdminController@anecDotalDataSheet');
Route::get('admin/anecdotal_data', 'AdminController@anecdotalData');
Route::post('anecdota_upload_image_file', 'AdminController@uploadImageAnecdotal');
Route::post('anecdotal_summary', 'AdminController@anecdotalSummary');

// counseling 

Route::get('admin/counseling', 'AdminController@counseling');
Route::get('counseling/data_sheet', 'AdminController@counselingDataSheet');
Route::get('admin/counseling_data', 'AdminController@counselingData');
Route::post('counseling_upload_image_file', 'AdminController@uploadImageCounseling');
Route::post('counseling_summary', 'AdminController@counselingSummary');

// Psychology 

Route::get('admin/psychology', 'AdminController@psychology');
Route::get('psychology/data_sheet', 'AdminController@psychologyDataSheet');
Route::get('admin/psychology_data', 'AdminController@psychologyData');
Route::post('psychology_upload_image_file', 'AdminController@uploadImagePsychology');
Route::post('psychology_summary', 'AdminController@psychologySummary');
// chat bot 

Route::get('admin/chatbot', 'AdminController@chatBot');
Route::get('admin/chatbot_data', 'AdminController@chatBotData');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::get('/admin/index', [
    'as' => 'admin.index',
    'uses' => 'AdminController@index',
    'middleware' => 'auth'
]);


Route::get('/user/index', [
    'as' => 'user.index',
    'uses' => 'StudentController@index',
    'middleware' => 'auth'
]);



Route::get('upload_image_file', 'FileUploadController@index');
Route::post('upload_image_file', 'FileUploadController@uploadImage');
Route::post('upload_image_student', 'FileUploadController@uploadImageStudent');
Route::post('studetUploadImageStudent', 'FileUploadController@studetUploadImageStudent');



Route::post('chatbot', 'StudentController@chatBot');



Route::post('register/create_student', 'StudentController@createStudent');
Route::post('save-conversation', 'StudentController@saveConversation');
Route::get('/get/classification_data/{classification_id}', 'StudentController@getClassificationLevel');


Route::get('admin/import','AdminController@import');
Route::post('import/import_excel', 'AdminController@importExcel');
Route::post('pc/post_import_data','AdminController@importPostExcel');





