@extends('site/layouts/main')


@stop


@section('content')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  
    <!-- Vendor CSS Files -->
    {{-- <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet"> --}}
  
    <link href="{{asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/js/min.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('assets/jquery/min.css')}}" rel="stylesheet"> --}}
    

    <style>

        body {
            font-family: "Roboto", serif;
        }
     .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border-bottom: 3px solid #007bff;
            flex-wrap: wrap;
            color:white;
        }

        /* Left Section (Logo & Form Label) */
        .header-left {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .logo {
            max-width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .form-label {
            border: 1px solid #ccc;
            padding: 5px 10px;
            font-size: 14px;
            background-color: #f8f8f8;
            font-weight: bold;
            border-radius: 5px;
            color: #333;
            text-transform: uppercase;
        }

        /* Center Section (Title & Description) */
        .header-title {
            text-align: center;
            flex: 1;
        }

        .header-title h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .header-title span {
            font-size: 16px;
            color: #555;
        }

        .header-title h2 {
            font-size: 18px;
            font-weight: bold;
            color: #444;
            margin-top: 5px;
        }

        /* Upload Box Styling */
        .upload-box {
            width: 120px;
            height: 120px;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
            color: #888;
            background-color: #f8f8f8;
            transition: 0.3s;
            border-radius: 5px;
            overflow: hidden;
            flex-direction: column;
            font-weight: bold;
            text-transform: uppercase;
        }

        .upload-box:hover {
            background-color: #eee;
        }

        .upload-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                text-align: center;
            }

            .upload-box {
                margin-top: 10px;
            }
        }
        .info-container {
            max-width: 800px;
            margin: 40px auto;
            text-align: center;
        }

        .info-container h4 {
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 5px solid #007bff;
            padding: 20px;
            border-radius: 8px;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            text-align: justify;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .info-box strong {
            color: #dc3545;
            font-weight: bold;
        }
        .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        border-color: #007bff;
    }

    .form-outline {
        margin-bottom: 1.5rem;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    /* Add subtle shadow to input fields */
    .form-control.shadow-sm {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    }

    /* Style the checkbox */
    .form-check-label {
        font-size: 0.95rem;
        color: #495057;
    }

    .form-label{
        font-size: 11px;
    }

    .form-check-input {
        width: 1.3em;
        height: 1.3em;
    }

        @media (max-width: 768px) {
            .info-box {
                font-size: 14px;
                padding: 15px;
            }
        }
    </style>


</head>
<body>

    <div class="container">
        <div class="header-container">
            <!-- Left Section: Logo & Form Label -->
            <div class="header-left">
                <img src="{{ asset('assets/img/gallery/asclogo.png') }}" alt="ASC Logo" class="img-fluid logo" style="width: 50%;">
                <div class="form-label">Guidance Form 1</div>
            </div>

            <!-- Center Section: Title & Description -->
            <div class="header-title">
                <h1>Andres Soriano Colleges</h1>
                <span>Mangagoy, Bislig City</span>
                <h2>Guidance Testing Center</h2>
                <h2>Personal Data Sheet</h2>
            </div>

            <div class="upload-box" id="uploadBox" style="border: 2px dashed #ccc; padding: 10px; text-align: center; cursor: pointer;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <label style="font-weight: bold;">2X2 ID PICTURE</label><br>
                <input type="file" id="imageInput" accept="image/*" style="display: none;">
                <div class="preview-container" style="width: 100px; height: 100px; margin: 10px auto; border: 1px solid #ddd;">
                    <img id="imagePreview" src="" alt="Image Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                </div>
            </div>
        </div>

        <h4>Dear Students:</h4>
        <div class="info-box">
            <p>
                The purpose of this form is to gather important information that will be of great help to all of us in the 
                <strong>Guidance and Counseling</strong> process. The success that you may expect in counseling will depend on your 
                honest and accurate responses. You don’t have to worry; <strong>ALL TRANSACTIONS WILL BE KEPT CONFIDENTIAL.</strong>
            </p>
        </div>




        <div class="mt-5">
            <form id="studentForm" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <!-- PERSONAL BACKGROUND SECTION -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h2 class="card-title mb-0">PERSONAL BACKGROUND</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <!-- First Name -->
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label" for="firstName">First Name</label>
                                            <input type="text" id="firstName" class="form-control shadow-sm rounded" name="first_name" id="first_name" value="{{ $person_details->first_name }}" />
                                        </div>
                                        <!-- Last Name -->
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label" for="lastName">Last Name</label>
                                            <input type="text" id="lastName" class="form-control shadow-sm rounded" name="last_name" id="last_name" value="{{ $person_details->last_name }}" />
                                        </div>
                                        <!-- Middle Name -->
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label" for="middleName">Middle Name</label>
                                            <input type="text" id="middleName" class="form-control shadow-sm rounded" name="middle_name" id="middle_name" {{ $person_details->middle_name }} />
                                        </div>
                                        <!-- Date -->
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label" for="studentDate" class="today_date" id="today_date">Date</label>
                                            <input type="date" id="studentDate" class="form-control shadow-sm rounded" name="today_date" id="today_date" />
                                        </div>
                                    </div>
                        
                                    <!-- Address Section -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="address" >Address</label>
                                                <input type="text" id="address" class="form-control shadow-sm rounded" name="address" id="address" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="placeOfBirth">Place of Birth</label>
                                                <input type="text" id="placeOfBirth" class="form-control shadow-sm rounded"  name="place_of_birth" id="place_of_birth" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="Studentreligion" class="religion" id="religion">Religion</label>
                                                <select name="religion_id" id="religion_id" class="form-control">
                                                    <option value="0">--Select--</option>
                                                    @foreach ($religion_list as $religion)
                                                        <option value="{{ $religion->id }}">{{ $religion->religion_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="studentEmail">Email Address</label>
                                                <input type="email" id="studentEmail" class="form-control shadow-sm rounded" name="student_email" id="student_email" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Sex Section -->
                                            <div class="mb-3">
                                                <label class="form-label">Sex</label>
                                                <div class="d-flex">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="gender_id" id="gender_id" value="1"/>
                                                        <label class="form-check-label" for="male">Male</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gender_id" id="gender_id" value="2" />
                                                        <label class="form-check-label" for="female">Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="civilStatus">Civil Status</label>
                                                <select name="civil_status_id" id="civil_status_id" class="form-control">
                                                    <option value="0">--Select--</option>
                                                    @foreach ($civil_status_list as $civil_status)
                                                        <option value="{{ $civil_status->id }}">{{ $civil_status->civil_status_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="dateOfBirth">Date of Birth</label>
                                                <input type="date" id="dateOfBirth" class="form-control shadow-sm rounded" name="birthdate" id="birthdate" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="citizenship">Citizenship</label>
                                                {{-- <input type="text" id="citizenship" class="form-control shadow-sm rounded" /> --}}
                                                <select name="citizenship_id" id="citizenship_id" class="form-control">
                                                    <option value="0">--Select--</option>
                                                    @foreach ($citizenship_list as $citizenship)
                                                        <option value="{{ $citizenship->id }}">{{ $citizenship->citizenship_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="studentmobileNumber">Mobile Number</label>
                                                <input type="tel" id="studentmobileNumber" class="form-control shadow-sm rounded" pattern="[0-9]{3}[0-9]{3}[0-9]{4}"  name="student_mobile_no" id="student_mobile_no"  />
                                            </div>
                                        </div>
                                    </div>
                        
                                    <!-- Working Student, Scholar, Single Parent Section -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Are you a working student?</label>
                                                <div class="d-flex">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="workingStudent" id="workingStudentYes" value="1" />
                                                        <label class="form-check-label" for="workingStudentYes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="workingStudent" id="workingStudentNo" value="0" />
                                                        <label class="form-check-label" for="workingStudentNo">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Are you a Scholar?</label>
                                                <div class="d-flex">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="scholar" id="scholarYes" value="1" />
                                                        <label class="form-check-label" for="scholarYes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="scholar" id="scholarNo" value="0" />
                                                        <label class="form-check-label" for="scholarNo">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Are you a single parent?</label>
                                                <div class="d-flex">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="singleParent" id="singleParentYes" value="1" />
                                                        <label class="form-check-label" for="singleParentYes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="singleParent" id="singleParentNo" value="0" />
                                                        <label class="form-check-label" for="singleParentNo">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="studentGuardian">If Yes, Who is your guardian?</label>
                                                <input type="text" id="studentGuardian" class="form-control shadow-sm rounded" name="who_guardian" id="who_guardian" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="studentSponsor">If Yes, Who is your sponsor?</label>
                                                <input type="text" id="studentSponsor" class="form-control shadow-sm rounded" name="who_sponsor" id="who_sponsor" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="studentChildren">If Yes, how many children do you have?</label>
                                                <input type="number" id="studentChildren" class="form-control shadow-sm rounded" name="many_children" id="many_children" />
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label" for="studentChildren">If married,name  of husband/wife</label>
                                                <input type="text" id="studentChildren" class="form-control shadow-sm rounded" name="married" id="married"  />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- FAMILY BACKGROUND SECTION -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h2 class="card-title mb-0">FAMILY BACKGROUND</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Father's Information -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="studentBrothers">No. of Brothers</label>
                                                <input type="text" id="studentBrothers" class="form-control shadow-sm rounded" name="no_bro" id="no_bro" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="fatherName">Father's Name</label>
                                                <input type="text" id="fatherName" class="form-control shadow-sm rounded" name="father_name" id="father_name" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="fatherAge">Age</label>
                                                <input type="text" id="fatherAge" class="form-control shadow-sm rounded" name="father_age" id="father_age" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="fatherAddress">Home Address</label>
                                                <input type="text" id="fatherAddress" class="form-control shadow-sm rounded" name="father_address" id="father_address" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="fatherEducation">Educational Attainment</label>
                                                <input type="text" id="fatherEducation" class="form-control shadow-sm rounded" name="father_educational" id="father_educational" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="fatherOccupation">Occupation</label>
                                                <input type="text" id="fatherOccupation" class="form-control shadow-sm rounded"  name="father_occupation" id="father_occupation" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="fatherMobile">Mobile Number</label>
                                                <input type="text" id="fatherMobile" class="form-control shadow-sm rounded" name="father_number" id="father_number"  />
                                            </div>
                                        </div>
                                        <!-- Mother's Information -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="studentSister">No. of Sisters</label>
                                                <input type="text" id="studentSister" class="form-control shadow-sm rounded" name="no_sis" id="no_sis" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="motherName">Mother's Name</label>
                                                <input type="text" id="motherName" class="form-control shadow-sm rounded" name="mother_name" id="mother_name"  />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="motherAge">Age</label>
                                                <input type="text" id="motherAge" class="form-control shadow-sm rounded" name="mother_age" id="mother_age" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="motherAddress">Home Address</label>
                                                <input type="text" id="motherAddress" class="form-control shadow-sm rounded" name="mother_address" id="mother_address" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="motherEducation">Educational Attainment</label>
                                                <input type="text" id="motherEducation" class="form-control shadow-sm rounded" name="mother_educational" id="mother_educational" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="motherOccupation">Occupation</label>
                                                <input type="text" id="motherOccupation" class="form-control shadow-sm rounded" name="mother_occupation" id="mother_occupation" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="motherMobile">Mobile Number</label>
                                                <input type="text" id="motherMobile" class="form-control shadow-sm rounded" name="mother_number" id="mother_number" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- EDUCATIONAL BACKGROUND SECTION -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h2 class="card-title mb-0">EDUCATIONAL BACKGROUND</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Education</th>
                                                <th>Name of School</th>
                                                <th>Subject You Like Best</th>
                                                <th>Subject You Don't Like</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Elementary</td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="School Name" id="elementaryName" name="elem" id="elem"></td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Like" id="elementarySubject" name="elem_sub_like" id="elem_sub_like"></td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Don't Like" id="elementarySubject" name="elem_sub_not_like" id="elem_sub_not_like"></td>
                                            </tr>
                                            <tr>
                                                <td>Junior High</td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="School Name" id="juniorHighName" name="jhs" id="jhs"></td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Like" id="juniorHighSubject" name="jhs_sub_like" id="jhs_sub_like"></td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Don't Like" id="juniorHighSubject" name="jhs_sub_not_like" id="jhs_sub_not_like"></td>
                                            </tr>
                                            <tr>
                                                <td>Grade 11</td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="School Name" id="grade11Name" name="g11" id="g11"></td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Like" id="grade11Subject" name="g11_sub_like" id="g11_sub_like"></td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Don't Like" id="grade11Subject" name="g11_sub_not_like" id="jhs_sub_not_like"></td>
                                            </tr>
                                            <tr>
                                                <td>Grade 12</td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="School Name" id="grade12Name" name="g12" id="g12"></td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Like" id="grade12Subject" name="g12_sub_like" id="g12_sub_like"></td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Don't Like" id="grade12Subject" name="g12_sub_not_like" id="g12_sub_not_like"></td>
                                            </tr>
                                            <tr>
                                                <td>College</td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="School Name" id="collegeName" name="college" id="college"></td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Like" id="collegeSubject" name="college_sub_like" id="college_sub_like"></td>
                                                <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Don't Like" id="collegeSubject"name="college_sub_not_like" id="college_sub_not_like"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h2 class="card-title mb-0">OTHER INFORMATION</h2>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td id="easiestSubjects">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter easiest subjects" name="easiest" id="easiest">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id="mostDifficultSubjects">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter most difficult subjects" name="most_diff_sub" id="most_diff_sub">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td itemid="lowestGrades">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter subjects with lowest grade" name="subj_lowest" id="subj_lowest">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id="planAfterHighSchool">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter plan after high school" name="plan_after_hs" id="plan_after_hs">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td id="highestGrades">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter subjects with highest grade" name="subj_highest_grade" id="subj_highest_grade">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id="awards">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter awards & honors" name="award" id="award">
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td id="emergencyContact">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter emergency contact" name="emergency_contact" id="emergency_contact">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h2 class="card-title mb-0">CHANGE PASSWORD</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered"> 
                                        <tbody>
                                            <tr>
                                                <td>Password</td>
                                                <td>
                                                    <input 
                                                        type="password" 
                                                        class="form-control shadow-sm rounded" 
                                                        placeholder="Password" 
                                                        id="password" 
                                                        name="password" 
                                                        onkeyup="checkPasswordMatch()"
                                                    >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Confirm Password</td>
                                                <td>
                                                    <input 
                                                        type="password" 
                                                        class="form-control shadow-sm rounded" 
                                                        placeholder="Confirm Password" 
                                                        id="confirm_password" 
                                                        name="confirm_password" 
                                                        onkeyup="checkPasswordMatch()"
                                                    >
                                                    <span id="message" style="color: red;"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                
   
                        <!-- SUBMIT BUTTON -->
                        <div class="text-right mb-4 container" >
                            <button type="button" class="btn btn-primary px-4" id="submit">
                                <span class="fa fa-save"></span> Save
                            </button>
                        </div>
            </form>
        </div>
  </form>
             
    </div>


    <script src={{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}></script>
    <script src={{asset('assets/vendor/php-email-form/validate.js')}}></script>
    <script src={{asset('assets/vendor/aos/aos.js')}}></script>
    <script src={{asset('assets/vendor/glightbox/js/glightbox.min.js')}}></script>
    <script src={{asset('assets/vendor/purecounter/purecounter_vanilla.js')}}></script>
    <script src={{asset('assets/vendor/jquery/min.js')}}></script>
    <script src={{asset('assets/vendor/swiper/swiper-bundle.min.js')}}></script>
    <script src={{asset('assets/js/min.js')}}></script>
    

    @section('scripts')
    <script>

function checkPasswordMatch() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    var message = document.getElementById("message");

    if (password === "" && confirmPassword === "") {
        message.innerHTML = "";
    } else if (password === confirmPassword) {
        message.style.color = "green";
        message.innerHTML = "Passwords match!";
    } else {
        message.style.color = "red";
        message.innerHTML = "Passwords do not match!";
    }
}

function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    // Basic password validation rules
    if (password.length < 8) {
        alert("Password must be at least 8 characters long");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match");
        return false;
    }

    // If all validations pass
    alert("Form submitted successfully!");
    return true;
}


    document.addEventListener("DOMContentLoaded", function () {
        
        let today = new Date().toISOString().split('T')[0];
        
        
        document.getElementById("studentDate").value = today;
    });

    document.addEventListener('DOMContentLoaded', function() {
    var uploadBox = document.getElementById('uploadBox');
    var imageInput = document.getElementById('imageInput');
    var imagePreview = document.getElementById('imagePreview');

    // Click to upload
    uploadBox.addEventListener('click', function() {
        imageInput.click();
    });

    // Function to upload file
    function uploadFile(file) {
        var formData = new FormData();
        formData.append('file', file);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ url("upload_image_student") }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.onload = function() {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                if (data.success) {
                    // Display success message
                    swal('Success', 'Image uploaded and saved successfully', 'success');
                    // Set the preview to the uploaded image path
                    imagePreview.src = '/' + data.image_path; // Ensure absolute path
                    imagePreview.style.display = 'block'; // Keep preview visible
                    imageInput.value = ''; // Clear input for next upload
                } else {
                    swal('Error', data.message || 'Upload failed', 'error');
                }
            } else {
                swal('Error', 'Upload failed: Server error', 'error');
            }
        };

        xhr.onerror = function() {
            swal('Error', 'Upload failed: Network error', 'error');
        };

        xhr.send(formData);
    }

    // Handle file selection and auto-upload
    imageInput.addEventListener('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            // Validate file type
            var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                swal('Error', 'Please upload only JPG or PNG images.', 'error');
                this.value = '';
                return;
            }

            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                swal('Error', 'Please upload an image smaller than 2MB.', 'error');
                this.value = '';
                return;
            }

            // Preview image before upload
            var reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';

                // Resize image to 2x2 inches (192x192 pixels at 96 DPI)
                resizeImage(e.target.result, 192, 192, function(resizedDataUrl) {
                    imagePreview.src = resizedDataUrl;

                    // Convert resized image back to file and upload
                    var blobBin = atob(resizedDataUrl.split(',')[1]);
                    var array = [];
                    for (var i = 0; i < blobBin.length; i++) {
                        array.push(blobBin.charCodeAt(i));
                    }
                    var resizedFile = new File([new Uint8Array(array)], file.name, { type: file.type });
                    uploadFile(resizedFile);
                });
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop
    uploadBox.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadBox.style.borderColor = '#000';
    });

    uploadBox.addEventListener('dragleave', function() {
        uploadBox.style.borderColor = '#ccc';
    });

    uploadBox.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadBox.style.borderColor = '#ccc';
        imageInput.files = e.dataTransfer.files;
        imageInput.dispatchEvent(new Event('change')); // Trigger the change event
    });

    // Image resize function
    function resizeImage(dataUrl, width, height, callback) {
        var img = new Image();
        img.onload = function() {
            var canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            var ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, width, height);
            callback(canvas.toDataURL('image/jpeg', 0.9));
        };
        img.src = dataUrl;
    }
});
        $(document).ready(function() {
           
    
            $("#submit").click(function(e) {
            e.preventDefault();
            
            const formData = new FormData(document.getElementById('studentForm'));

            $.ajax({
                url: "{{ url('student/create_pds') }}",
                type: 'POST',
                data: formData,
                processData: false, 
                contentType: false, 
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Student Personal Data Sheet successfully saved!',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to save student.',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while saving students.',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });

            
    
    
        });
    </script>
    @stop
    
</body>
</html>