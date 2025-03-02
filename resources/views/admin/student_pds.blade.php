@extends('site/layouts/main')
@stop


@section('content')

<style>
  .holiday {
    background-color: red !important;
    color: white !important;
  }
</style>

<div class="container-fluid">
	<script>
		var isFluid = JSON.parse(localStorage.getItem('isFluid'));
            if (isFluid) {
              var container = document.querySelector('[data-layout]');
              container.classList.remove('container');
              container.classList.add('container-fluid');
            }
	</script>

	<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
		<script>
			var navbarStyle = localStorage.getItem("navbarStyle");
                if (navbarStyle && navbarStyle !== 'transparent') {
                  document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
                }
		</script>
		<div class="d-flex align-items-center">
			<div class="toggle-icon-wrapper">
				{{-- <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
					data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span
							class="toggle-line"></span></span></button> --}}
			</div><a class="navbar-brand" href="{{URL::to('')}}">
				<div class="d-flex align-items-center py-3">
					<span class="font-sans-serif" style="color:#DE9208; font-size:13px">
          GUIDANCE SYSTEM
					</span>
				</div>
			</a>
		</div>

		@include('admin_sidebar');

	</nav>


	<div class="content">
		<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">
			{{-- <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
				data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
				aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span
					class="navbar-toggle-icon"><span class="toggle-line"></span></span></button> --}}


			<ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
				<li class="nav-item">
                    @if (Auth::check())
                        <p class="dropdown-item">Hi Admin, {{ Auth::user()->name }}</p>
                    @endif
					<div class="theme-control-toggle fa-icon-wait px-2"><input
							class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle"
							type="checkbox" data-theme-control="theme" value="dark" /><label
							class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle"
							data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to light theme"><span
								class="fas fa-sun fs-0"></span></label><label
							class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle"
							data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to dark theme"><span
								class="fas fa-moon fs-0"></span></label></div>
				</li>



				<li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button"
						data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<div class="avatar avatar-xl">
              <img class="rounded-circle" src="{{ asset('assets/site/images/user.png') }}" alt="User Image" />
						</div>
					</a>
					<div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0"
						aria-labelledby="navbarDropdownUser">
						<div class="bg-white dark__bg-1000 rounded-2 py-2">
							{{-- <a class="dropdown-item" href="{{ url('') }}" target="_blank">Profile &amp; account</a> --}}
							<a class="dropdown-item" href="{{URL::to('auth/logout')}}">Logout</a>
						</div>
					</div>
				</li>
			</ul>
		</nav>

		<script>
			var navbarPosition = localStorage.getItem('navbarPosition');
                var navbarVertical = document.querySelector('.navbar-vertical');
                var navbarTopVertical = document.querySelector('.content .navbar-top');
                var navbarTop = document.querySelector('[data-layout] .navbar-top:not([data-double-top-nav');
                var navbarDoubleTop = document.querySelector('[data-double-top-nav]');
                var navbarTopCombo = document.querySelector('.content [data-navbar-top="combo"]');
    
                if (localStorage.getItem('navbarPosition') === 'double-top') {
                  document.documentElement.classList.toggle('double-top-nav-layout');
                }
    
                if (navbarPosition === 'top') {
                  navbarTop.removeAttribute('style');
                  navbarTopVertical.remove(navbarTopVertical);
                  navbarVertical.remove(navbarVertical);
                  navbarTopCombo.remove(navbarTopCombo);
                  navbarDoubleTop.remove(navbarDoubleTop);
                } else if (navbarPosition === 'combo') {
                  navbarVertical.removeAttribute('style');
                  navbarTopCombo.removeAttribute('style');
                  // navbarTop.remove(navbarTop);
                  navbarTopVertical.remove(navbarTopVertical);
                  navbarDoubleTop.remove(navbarDoubleTop);
                } else if (navbarPosition === 'double-top') {
                  navbarDoubleTop.removeAttribute('style');
                  navbarTopVertical.remove(navbarTopVertical);
                  navbarVertical.remove(navbarVertical);
                  // navbarTop.remove(navbarTop);
                  navbarTopCombo.remove(navbarTopCombo);
                } else {
                  navbarVertical.removeAttribute('style');
                  navbarTopVertical.removeAttribute('style');
                  // navbarTop.remove(navbarTop);
                  // navbarDoubleTop.remove(navbarDoubleTop);
                  // navbarTopCombo.remove(navbarTopCombo);
                }
		</script>

		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

		    <div class="card mb-3">
            <div class="card-body">
              <div class="row flex-between-center">
                <div class="col-md">
                  <h5 class="mb-2 mb-md-0">Welcome Back Admin!</h5>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
                <form id="studentForm" autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="person_id" value="{{ $person_id }}" />
                    <!-- PERSONAL BACKGROUND SECTION -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h2 class="card-title mb-0" style="color:white;">PERSONAL BACKGROUND</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <!-- First Name -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="firstName">First Name</label>
                                                <input type="text" id="firstName" class="form-control shadow-sm rounded" name="first_name" id="first_name" value="{{ $person->first_name }}"  readonly/>
                                            </div>
                                            <!-- Last Name -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="lastName">Last Name</label>
                                                <input type="text" id="lastName" class="form-control shadow-sm rounded" name="last_name" id="last_name" value="{{ $person->last_name }}" readonly />
                                            </div>
                                            <!-- Middle Name -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="middleName">Middle Name</label>
                                                <input type="text" id="middleName" class="form-control shadow-sm rounded" name="middle_name" id="middle_name" value="{{ $person->middle_name }}"  readonly/>
                                            </div>
                                            <!-- Date -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="studentDate" class="today_date" id="today_date">Date</label>
                                                <input type="date" id="studentDate" class="form-control shadow-sm rounded" name="today_date" id="today_date" value="{{ $person->date_input }}" />
                                            </div>
                                        </div>
                            
                                        <!-- Address Section -->
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="address" >Address</label>
                                                    <input type="text" id="address" class="form-control shadow-sm rounded" name="address" id="address" value="{{ $person->address }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="placeOfBirth">Place of Birth</label>
                                                    <input type="text" id="placeOfBirth" class="form-control shadow-sm rounded"  name="place_of_birth" id="place_of_birth" value="{{ $person->place_of_birth }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="Studentreligion">Religion</label>
                                                    <select name="religion_id" id="religion_id" class="form-control">
                                                        <option value="0">--Select--</option>
                                                        @foreach ($religion_list as $religion)
                                                            <option value="{{ $religion->id }}" 
                                                                {{ $person->religion_id == $religion->id ? 'selected' : '' }}>
                                                                {{ $religion->religion_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label" for="studentEmail">Email Address</label>
                                                    <input type="email" id="studentEmail" class="form-control shadow-sm rounded" name="student_email" id="student_email" value="{{ $person->email_address }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Sex Section -->
                                                <div class="mb-3">
                                                    <label class="form-label">Sex</label>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="gender_id" id="male" value="1" 
                                                                {{ $person->gender_id == 1 ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="male">Male</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="gender_id" id="female" value="2" 
                                                                {{ $person->gender_id == 2 ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="female">Female</label>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="civilStatus">Civil Status</label>
                                                    <select name="civil_status_id" id="civil_status_id" class="form-control">
                                                        <option value="0">--Select--</option>
                                                        @foreach ($civil_status_list as $civil_status)
                                                            <option value="{{ $civil_status->id }}" 
                                                                {{ $person->civil_status_id == $civil_status->id ? 'selected' : '' }}>
                                                                {{ $civil_status->civil_status_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="dateOfBirth">Date of Birth</label>
                                                    <input type="date" id="dateOfBirth" class="form-control shadow-sm rounded" name="birthdate" id="birthdate" value="{{ $person->birthdate }}"/>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="citizenship">Citizenship</label>
                                                    <select name="citizenship_id" id="citizenship_id" class="form-control">
                                                        <option value="0">--Select--</option>
                                                        @foreach ($citizenship_list as $citizenship)
                                                            <option value="{{ $citizenship->id }}" 
                                                                {{ $person->citizenship_id == $citizenship->id ? 'selected' : '' }}>
                                                                {{ $citizenship->citizenship_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="studentmobileNumber">Mobile Number</label>
                                                    <input type="tel" id="studentmobileNumber" class="form-control shadow-sm rounded" pattern="[0-9]{3}[0-9]{3}[0-9]{4}"  name="student_mobile_no" id="student_mobile_no" value="{{ $person->mobile_number }}"  />
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
                                                            <input class="form-check-input" type="radio" name="workingStudent" id="workingStudentYes" value="1"
                                                                {{ isset($other_survey) && $other_survey->working_student == 1 ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="workingStudentYes">Yes</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="workingStudent" id="workingStudentNo" value="0"
                                                                {{ isset($other_survey) && $other_survey->working_student == 0 ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="workingStudentNo">No</label>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Are you a Scholar?</label>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="scholar" id="scholarYes" value="1"
                                                            {{ isset($survey) && $survey->scholar == 1 ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="scholarYes">Yes</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="scholar" id="scholarNo" value="0"
                                                            {{ isset($survey) && $survey->scholar == 0 ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="scholarNo">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Are you a single parent?</label>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="singleParent" id="singleParentYes" value="1"
                                                            {{ isset($survey) && $survey->single_parent == 1 ? 'checked' : '' }}  />
                                                            <label class="form-check-label" for="singleParentYes">Yes</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="singleParent" id="singleParentNo" value="1"
                                                            {{ isset($survey) && $survey->single_parent == 0 ? 'checked' : '' }}  />
                                                            <label class="form-check-label" for="singleParentNo">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="studentGuardian">If Yes, Who is your guardian?</label>
                                                    <input type="text" id="studentGuardian" class="form-control shadow-sm rounded" name="who_guardian" value="{{ isset($survey) ? $survey->guardian : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="studentSponsor">If Yes, Who is your sponsor?</label>
                                                    <input type="text" id="studentSponsor" class="form-control shadow-sm rounded" name="who_sponsor" value="{{ isset($survey) ? $survey->sponsor : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="studentChildren">If Yes, how many children do you have?</label>
                                                    <input type="number" id="studentChildren" class="form-control shadow-sm rounded" name="many_children" value="{{ isset($survey) ? $survey->children : '' }}" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-8">
                                                <label class="form-label" for="studentChildren">If married, name of husband/wife</label>
                                                <input type="text" id="studentChildren" class="form-control shadow-sm rounded" name="married" value="{{ isset($survey) ? $survey->married : '' }}" />
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- FAMILY BACKGROUND SECTION -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h2 class="card-title mb-0" style="color:white;">FAMILY BACKGROUND</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Father's Information -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="studentBrothers">No. of Brothers</label>
                                                    <input type="text" id="studentBrothers" class="form-control shadow-sm rounded" name="no_bro" 
                                                        value="{{ isset($famiy_background->no_brother) ? $famiy_background->no_brother : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="fatherName">Father's Name</label>
                                                    <input type="text" id="fatherName" class="form-control shadow-sm rounded" name="father_name"
                                                        value="{{ isset($famiy_background->father_name) ? $famiy_background->father_name : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="fatherAge">Age</label>
                                                    <input type="text" id="fatherAge" class="form-control shadow-sm rounded" name="father_age"
                                                        value="{{ isset($famiy_background->father_age) ? $famiy_background->father_age : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="fatherAddress">Home Address</label>
                                                    <input type="text" id="fatherAddress" class="form-control shadow-sm rounded" name="father_address"
                                                        value="{{ isset($famiy_background->father_address) ? $famiy_background->father_address : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="fatherEducation">Educational Attainment</label>
                                                    <input type="text" id="fatherEducation" class="form-control shadow-sm rounded" name="father_educational"
                                                        value="{{ isset($famiy_background->father_educational) ? $famiy_background->father_educational : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="fatherOccupation">Occupation</label>
                                                    <input type="text" id="fatherOccupation" class="form-control shadow-sm rounded" name="father_occupation"
                                                        value="{{ isset($famiy_background->father_occupation) ? $famiy_background->father_occupation : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="fatherMobile">Mobile Number</label>
                                                    <input type="text" id="fatherMobile" class="form-control shadow-sm rounded" name="father_number"
                                                        value="{{ isset($famiy_background->father_mobile) ? $famiy_background->father_mobile : '' }}" />
                                                </div>
                                            </div>
                                            <!-- Mother's Information -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="studentSister">No. of Sisters</label>
                                                    <input type="text" id="studentSister" class="form-control shadow-sm rounded" name="no_sis"
                                                        value="{{ isset($famiy_background->no_sister) ? $famiy_background->no_sister : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="motherName">Mother's Name</label>
                                                    <input type="text" id="motherName" class="form-control shadow-sm rounded" name="mother_name"
                                                        value="{{ isset($famiy_background->mother_name) ? $famiy_background->mother_name : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="motherAge">Age</label>
                                                    <input type="text" id="motherAge" class="form-control shadow-sm rounded" name="mother_age"
                                                        value="{{ isset($famiy_background->mother_age) ? $famiy_background->mother_age : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="motherAddress">Home Address</label>
                                                    <input type="text" id="motherAddress" class="form-control shadow-sm rounded" name="mother_address"
                                                        value="{{ isset($famiy_background->mother_address) ? $famiy_background->mother_address : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="motherEducation">Educational Attainment</label>
                                                    <input type="text" id="motherEducation" class="form-control shadow-sm rounded" name="mother_educational"
                                                        value="{{ isset($famiy_background->mother_educational) ? $famiy_background->mother_educational : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="motherOccupation">Occupation</label>
                                                    <input type="text" id="motherOccupation" class="form-control shadow-sm rounded" name="mother_occupation"
                                                        value="{{ isset($famiy_background->mother_occupation) ? $famiy_background->mother_occupation : '' }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="motherMobile">Mobile Number</label>
                                                    <input type="text" id="motherMobile" class="form-control shadow-sm rounded" name="mother_number"
                                                        value="{{ isset($famiy_background->mother_mobile) ? $famiy_background->mother_mobile : '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            
                                <!-- EDUCATIONAL BACKGROUND SECTION -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h2 class="card-title mb-0" style="color:white;">EDUCATIONAL BACKGROUND</h2>
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
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="School Name" id="elementaryName" name="elem" value="{{ isset($education_background) ? $education_background->elem_school : '' }}"></td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Like" id="elementarySubject" name="elem_sub_like" value="{{ isset($education_background) ? $education_background->elem_subject_like : '' }}"></td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Don't Like" id="elementarySubject" name="elem_sub_not_like" value="{{ isset($education_background) ? $education_background->elem_subject_not_like : '' }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Junior High</td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="School Name" id="juniorHighName" name="jhs" value="{{ isset($education_background) ? $education_background->jhs_school : '' }}"></td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Like" id="juniorHighSubject" name="jhs_sub_like" value="{{ isset($education_background) ? $education_background->jhs_subject_like : '' }}"></td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Don't Like" id="juniorHighSubject" name="jhs_sub_not_like" value="{{ isset($education_background) ? $education_background->jhs_subject_not_like : '' }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Grade 11</td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="School Name" id="grade11Name" name="g11" value="{{ isset($education_background) ? $education_background->g11_school : '' }}"></td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Like" id="grade11Subject" name="g11_sub_like" value="{{ isset($education_background) ? $education_background->g11_subject_like : '' }}"></td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Don't Like" id="grade11Subject" name="g11_sub_not_like" value="{{ isset($education_background) ? $education_background->g11_subject_not_like : '' }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Grade 12</td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="School Name" id="grade12Name" name="g12" value="{{ isset($education_background) ? $education_background->g12_school : '' }}"></td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Like" id="grade12Subject" name="g12_sub_like" value="{{ isset($education_background) ? $education_background->g12_subject_like : '' }}"></td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Don't Like" id="grade12Subject" name="g12_sub_not_like" value="{{ isset($education_background) ? $education_background->g12_subject_not_like : '' }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>College</td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="School Name" id="collegeName" name="college" value="{{ isset($education_background) ? $education_background->college_school : '' }}"></td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Like" id="collegeSubject" name="college_sub_like" value="{{ isset($education_background) ? $education_background->college_subject_like : '' }}"></td>
                                                    <td><input type="text" class="form-control shadow-sm rounded" placeholder="Subject You Don't Like" id="collegeSubject" name="college_sub_not_like" value="{{ isset($education_background) ? $education_background->college_subject_not_like : '' }}"></td>
                                                </tr>
                                            </tbody>
                                            
                                            
                                        </table>
                                    </div>
    
    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td id="easiestSubjects">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter easiest subjects" name="easiest" id="easiest" value="{{ isset($other_survey) ? $other_survey->easiest_sub : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id="mostDifficultSubjects">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter most difficult subjects" name="most_diff_sub" id="most_diff_sub" value="{{ isset($other_survey) ? $other_survey->most_difficult_sub : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id="lowestGrades">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter subjects with lowest grade" name="subj_lowest" id="subj_lowest" value="{{ isset($other_survey) ? $other_survey->sub_with_lowest : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id="planAfterHighSchool">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter plan after high school" name="plan_after_hs" id="plan_after_hs" value="{{ isset($other_survey) ? $other_survey->plan_after_hs : '' }}">
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
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter subjects with highest grade" name="subj_highest_grade" id="subj_highest_grade" value="{{ isset($other_survey) ? $other_survey->sub_with_highest : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id="awards">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter awards & honors" name="award" id="award" value="{{ isset($other_survey) ? $other_survey->awards : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id="emergencyContact">
                                                        <input type="text" class="form-control shadow-sm rounded" placeholder="Enter emergency contact" name="emergency_contact" id="emergency_contact" value="{{ isset($person) ? $person->incase_of_emergency : '' }}">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="text-right mb-4 container" >
                                <button type="button" class="btn btn-primary px-4" id="submit">
                                    <span class="fa fa-save"></span> Save
                                </button>
                            </div>
                        </div>
                    
       
                            <!-- SUBMIT BUTTON -->
                </form>
            </div>
        </div>



        
          
		  



@stop

@section('scripts')
<script>

$(document).ready(function() {
           $("#submit").click(function(e) {
                e.preventDefault();
                
                const formData = new FormData(document.getElementById('studentForm'));
                formData.append('person_id', $("input[name='person_id']").val());
                $.ajax({
                    url: "{{ url('student/update_pds') }}",
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





