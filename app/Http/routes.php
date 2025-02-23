<?php


Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('/studentForm', 'StudentController@index');
Route::post('student/create_pds', 'StudentController@createPds');

// Route::pos

Route::post('student/studentFormSave', 'StudentController@store');


Route::get('admin/student_pds', 'AdminController@getStudentPds');
Route::get('admin/student_profile', 'AdminController@getStudentProfile');

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



Route::post('chatbot', 'StudentController@chatBot');



Route::post('register/create_student', 'StudentController@createStudent');
Route::post('save-conversation', 'StudentController@saveConversation');
Route::get('/get/classification_data/{classification_id}', 'StudentController@getClassificationLevel');




