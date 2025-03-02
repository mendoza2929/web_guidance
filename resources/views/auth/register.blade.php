
@extends('site/layouts/main')
@stop

@section('content')



    <style>
        .form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 350px;
            background-color: #fff;
            padding: 20px;
            border-radius: 20px;
            position: relative;
        }

        .title {
            font-size: 28px;
            color: royalblue;
            font-weight: 600;
            letter-spacing: -1px;
            position: relative;
            display: flex;
            align-items: center;
            padding-left: 30px;
        }

        .title::before,
        .title::after {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            border-radius: 50%;
            left: 0px;
            background-color: royalblue;
        }

        .title::before {
            width: 18px;
            height: 18px;
            background-color: royalblue;
        }

        .title::after {
            width: 18px;
            height: 18px;
            animation: pulse 1s linear infinite;
        }

        .message,
        .signin {
            color: rgba(88, 87, 87, 0.822);
            font-size: 14px;
        }

        .signin {
            text-align: center;
        }

        .signin a {
            color: royalblue;
        }

        .signin a:hover {
            text-decoration: underline royalblue;
        }

        .flex {
            display: flex;
            width: 100%;
            gap: 6px;
        }

        .form label {
            position: relative;
        }

        .form label .input {
            width: 100%;
            padding: 10px 10px 20px 10px;
            outline: 0;
            border: 1px solid rgba(105, 105, 105, 0.397);
            border-radius: 10px;
        }

        .form label .input+span {
            position: absolute;
            left: 10px;
            top: 15px;
            color: grey;
            font-size: 0.9em;
            cursor: text;
            transition: 0.3s ease;
        }

        .form label .input:placeholder-shown+span {
            top: 15px;
            font-size: 0.9em;
        }

        .form label .input:focus+span,
        .form label .input:valid+span {
            top: 0px;
            font-size: 0.7em;
            font-weight: 600;
        }

        .form label .input:valid+span {
            color: green;
        }

        .submit {
            border: none;
            outline: none;
            background-color: royalblue;
            padding: 10px;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            transform: .3s ease;
        }

        .submit:hover {
            background-color: rgb(56, 90, 194);
            cursor: pointer;
        }

        @keyframes pulse {
            from {
                transform: scale(0.9);
                opacity: 1;
            }

            to {
                transform: scale(1.8);
                opacity: 0;
            }
        }

        .center-form {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            padding: 40px;
        }
        .tab {
            display: flex;
            cursor: pointer;
            padding: 10px;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            width: 300px;
            margin: 0 auto;
        }

        .tab div {
            padding: 10px;
            flex: 1;
            text-align: center;
            background-color: #ddd;
            border-right: 1px solid #ccc;
        }

        .tab div:last-child {
            border-right: none;
        }

        .tab div.active {
            background-color: #fff;
            border-bottom: 2px solid #007BFF;
        }

        .form-container {
            display: none;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            width: 100%;
        }

        .form-container.active {
            display: block;
        }

        .form {
            max-width: 400px;
            margin: 0 auto;
        }

        .form label {
            display: block;
            margin-bottom: 10px;
        }

        .form .input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .submit {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .signin {
            text-align: center;
            margin-top: 20px;
        }

        .signup-link {
            color: #007BFF;
            text-decoration: none;
        }

        .teacher_flex{
            display: flex;
            gap: 20px; /* Adds spacing between elements */
            flex-wrap: wrap;
            
        }

        .teacher_flex label {
        flex: 1; /* Ensures equal width unless otherwise specified */
        }

        .teacher_flex label:nth-child(1) {
            flex-basis: 50%; /* Gender field gets 40% width */
        }

        .teacher_flex label:nth-child(2) {
            flex-basis: 20%; /* Age field gets 20% width */
        }

        .password-container {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .input {
        width: 100%;
        padding-right: 40px; /* To avoid text overlapping with the icon */
    }
    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
            
    </style>

  <div class="tab">
	<div id="parentTab" class="active">STUDENT INFOMTION</div>
</div>


<div class="center-form">

	<div id="studentForm" class="form-container active">
		<form class="form" id="createStudentForm"  autocomplete="off"> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<p class="title">Register Student</p>
			<p class="message">Signup now and get full access to our system.</p>
	
			<fieldset>
				<h4>Name of Student</h4>
				<div class="flex">
					<label>
						<input class="input" type="text" name="first_name" id="first_name" required>
						<span>First name</span>
					</label>
	
					<label>
						<input class="input" type="text"  name="middle_name" id="middle_name"  required>
						<span>Middle name</span>
					</label>
	
					<label>
						<input class="input" type="text"  name="last_name" id="last_name"  required>
						<span>Last name</span>
					</label>
				</div>
				<label>
					<input class="input" type="text"  name="email" id="email"  required>
					<span>Email</span>
				</label>
			</fieldset>
			<fieldset>
				<label>
					<span>Department Type</span>
					<select name="classification_id" id="classification_id" class="form-control">
						@foreach (\App\Classification::all() as $classification)
							<option value="{{ $classification->id }}">{{ $classification->classification_name }}</option>
						@endforeach
					</select>
				</label>

				<label>
					<span>Department</span>
					<select name="school_department_id" id="school_department_id" class="form-control">
						
					</select>
				</label>

				<label>
					<span>Level</span>
					<select name="classification_level_id" id="classification_level_id" class="form-control">
						
					</select>
				</label>
			</fieldset>
			<fieldset>
				<legend>Account Information</legend>
				<label class="password-container">
                    <input class="input" type="password" name="password" id="password" required>
                    <span>Password</span>
                    <i class="toggle-password" onclick="togglePassword('password', this)">👁️</i>
                </label>
                
                <label class="password-container">
                    <input class="input" type="password" name="confirm_password" id="confirm_password" required>
                    <span>Confirm Password</span>
                    <i class="toggle-password" onclick="togglePassword('confirm_password', this)">👁️</i>
                </label>
                <span id="password-error" style="color:red; display:none;">Passwords do not match!</span>
			</fieldset>
	
            <div class="modal-footer d-flex justify-content-end align-items-center bg-light border-0">
                <button type="button" class="btn btn-success px-4 w-100" id="saveStudentBtn">
                    <span class="fa fa-save"></span> Save
                </button>
            </div>
            
			<p class="signin">Already have an account? <a href="{{ url('/auth/login') }}" class="signup-link">Sign In</a></p>
		</form>
	</div>
</div>
@stop
@section('scripts')
<script>

function togglePassword(inputId, icon) {
        let input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈"; 
        } else {
            input.type = "password";
            icon.textContent = "👁️"; 
        }
    }
    $(document).ready(function(){


		$('#classification_id').on('change', function () {
        var classificationId = $(this).val();

        // Clear dropdowns and show loading message
        $('#classification_level_id').empty().append('<option value="">Loading...</option>');
        $('#school_department_id').empty().append('<option value="">--Select--</option>');

        if (classificationId) {
            $.ajax({
                url: "{{ url('get/classification_data/') }}/" + classificationId, 
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#classification_level_id').empty().append('<option value="">Select Level</option>');
                    $.each(data.classification_levels, function (index, level) {
                        $('#classification_level_id').append('<option value="' + level.id + '">' + level.level + '</option>');
                    });

                    $.each(data.school_departments, function (index, department) {
                        $('#school_department_id').append('<option value="' + department.id + '">' + department.department_name + '</option>');
                    });
                }
            });
        } else {
            $('#classification_level_id').empty().append('<option value="">Select Classification Level</option>');
            $('#school_department_id').empty().append('<option value="">Select School Department</option>');
        }
    });
    $("#saveStudentBtn").click(function(){
    const formData = new FormData(document.getElementById('createStudentForm'));
    formData.append('role', 'student'); 

    $.ajax({
        url: "{{ url('register/create_student') }}",
        type: "POST",
        dataType: 'json',
        contentType: false,
        processData: false,
        data: formData,
        success: function(response){
            location.reload();
        },
        error: function(xhr, status, error){
            iziToast.error({
                title: 'Error',
                message: 'Unable to save schedule. Please try again.',
                position: 'topRight',
                timeout: 3000,
            });
        }
    });
});



    const parentTab = document.getElementById('parentTab');
	const teacherTab = document.getElementById('teacherTab');
	const parentForm = document.getElementById('parentForm');
	const teacherForm = document.getElementById('teacherForm');

	parentTab.addEventListener('click', function() {
		parentTab.classList.add('active');
		teacherTab.classList.remove('active');
		parentForm.classList.add('active');
		teacherForm.classList.remove('active');
	});

	teacherTab.addEventListener('click', function() {
		teacherTab.classList.add('active');
		parentTab.classList.remove('active');
		teacherForm.classList.add('active');
		parentForm.classList.remove('active');
	});

    function calculateAge(birthdate) {
        const birthDateObj = new Date(birthdate);
        const today = new Date();
        let age = today.getFullYear() - birthDateObj.getFullYear();
        const monthDifference = today.getMonth() - birthDateObj.getMonth();
 
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDateObj.getDate())) {
            age--;
        }
        return age;
    }
    document.querySelector('.birthdate').addEventListener('change', function() {
        const birthdate = this.value;
        const age = calculateAge(birthdate);
        document.querySelector('.age').value = age;
    });

    function checkPasswords() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorMessage = document.getElementById('password-error');

        if (password !== confirmPassword) {
            errorMessage.style.display = 'inline';
        } else {
            errorMessage.style.display = 'none'; 
        }
    }

    document.getElementById('confirm_password').addEventListener('input', checkPasswords);
    document.getElementById('password').addEventListener('input', checkPasswords);


    
    function TeachercheckPasswords() {
        const password = document.getElementById('teacher_password').value;
        const confirmPassword = document.getElementById('teacher_confirm_password').value;
        const errorMessage = document.getElementById('teacher-password-error');

        if (password !== confirmPassword) {
            errorMessage.style.display = 'inline';
        } else {
            errorMessage.style.display = 'none'; 
        }
    }

    document.getElementById('teacher_confirm_password').addEventListener('input', TeachercheckPasswords);
    document.getElementById('teacher_password').addEventListener('input', TeachercheckPasswords);

	
    
    });

</script>
@stop
