@extends('site/layouts/main')


@stop


@section('content')

<style>
         .drop_box {
            border: 2px dashed #007bff;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .drop_box header h4 {
            margin: 0;
            font-size: 1.25rem;
        }
        .btn-primary-custom-excel, .btn-primary-custom-filter {
            margin-right: 10px;
        }
        #file-names {
            margin-top: 20px;
        }

        textarea {
        resize: none;
        width: 100%;
        height: 150px;
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

        {{-- <div class="container mt-5">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row flex-between-center">
                        <div class="col-md">
                            <h5 class="mb-2 mb-md-0">Psychology Test</h5>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="drop_box" id="drop-area">
                                <header>
                                    <h4>Drag & Drop Images Here or Click Choose Files</h4>
                                </header>
                                <p>Supported File Types: jpg, jpeg, png</p>
                                
                                <form id="file-upload-form" action="{{ url('upload_image_file') }}" method="POST" enctype="multipart/form-data">     
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="file" name="files[]" id="file" multiple accept=".jpg,.jpeg,.png" style="display: none;">
                                    <div class="form-group mt-3">
                                        <button type="button" class="btn btn-primary btn-sm" id="choose-files-btn">
                                            <span class="fa fa-folder-open-o"></span> Choose Files
                                        </button>
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <span class="fa fa-upload"></span> Upload Files
                                        </button>
                                    </div>
                                    <div id="counting_container" class="mt-3"></div>
                                    <div id="file-names" class="mt-3"></div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row flex-between-center">
                                <div class="col-md">
                                    <h4>Summary</h4>
                                    <textarea name="psychology_summary" id="psychology_summary" cols="30" rows="10"></textarea>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <button class="btn btn-primary mt-3" style="text-align: center" id="psychologyBtn">Save</button>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="container mt-5">
            <div class="card result-card">
                <div class="card-body">
                    <h3 class="mb-4">Aptitude Test Results</h3>
        
                    @if (isset($message))
                        <!-- Display message if no results -->
                        <div class="alert alert-warning" role="alert">
                            {{ $message }}
                        </div>
                        {{-- <div class="mt-4">
                            <a href="{{ route('aptitude.test') }}" class="btn btn-primary">Take the Test</a>
                        </div> --}}
                    @else
                        <!-- Score Summary -->
                        <div class="score-summary">
                            <h5>Your Score: {{ number_format($scorePercentage, 2) }}%</h5>
                            <p>Total Questions: {{ $totalQuestions }}</p>
                            <p>Correct Answers: {{ $correctAnswers }}</p>
                            <p>Incorrect Answers: {{ $incorrectAnswers }}</p>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $scorePercentage }}%" 
                                     aria-valuenow="{{ $scorePercentage }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ number_format($scorePercentage, 2) }}%
                                </div>
                            </div>
                            <!-- Feedback Message -->
                            <div class="alert alert-info" role="alert">
                                <strong>Feedback:</strong> {{ $feedback }}
                            </div>
                        </div>
        
                        <!-- Detailed Results -->
                        <h5>Detailed Results</h5>
                        @if ($results->isEmpty())
                            <p>No results found. Please take the test first.</p>
                        @else
                            @foreach ($results as $index => $result)
                                <div class="question-item">
                                    <p><strong>{{ $index + 1 }}. {{ $result->question }}</strong></p>
                                    <p>Your Answer: {{ $result->user_answer }} 
                                        <span class="{{ $result->is_correct ? 'correct' : 'incorrect' }}">
                                            ({{ $result->is_correct ? 'Correct' : 'Incorrect' }})
                                        </span>
                                    </p>
                                    @if (!$result->is_correct)
                                        <p>Correct Answer: {{ $result->correct_answer }}</p>
                                    @endif
                                </div>
                            @endforeach
                        @endif
        
                        <!-- Back to Test Button -->
                        {{-- <div class="mt-4">
                            <a href="{{ route('aptitude.test') }}" class="btn btn-primary">Take Another Test</a>
                        </div> --}}
                    @endif
                </div>
            </div>
        </div>
        

        
          
		  



@stop


@section('scripts')
<script>
   const dropArea = document.getElementById("drop-area");
    const fileInput = document.getElementById("file");
    const fileNamesDiv = document.getElementById("file-names");
    const chooseFilesBtn = document.getElementById("choose-files-btn");
    const form = document.getElementById("file-upload-form");

    // Allowed file extensions
    const allowedExtensions = ["jpg", "jpeg", "png"];
    
    // Drag-and-Drop functionality
    dropArea.addEventListener("dragover", (event) => {
        event.preventDefault();
        dropArea.classList.add("active");
    });

    dropArea.addEventListener("dragleave", () => {
        dropArea.classList.remove("active");
    });

    dropArea.addEventListener("drop", (event) => {
        event.preventDefault();
        dropArea.classList.remove("active");

        // Validate dragged files
        const validFiles = Array.from(event.dataTransfer.files).filter((file) => {
            const fileExtension = file.name.split(".").pop().toLowerCase();
            return allowedExtensions.includes(fileExtension);
        });

        if (validFiles.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Files Detected',
                text: `Only ${allowedExtensions.join(", ")} files are allowed.`,
            });
            return;
        }

        // Append valid files to the file input
        const dataTransfer = new DataTransfer();
        Array.from(fileInput.files).forEach((file) => dataTransfer.items.add(file)); // Keep existing files
        validFiles.forEach((file) => dataTransfer.items.add(file)); // Add new valid files
        fileInput.files = dataTransfer.files;

        // Display file names
        displayFileNames(fileInput.files);
    });

    // Trigger file input click with "Choose Files" button
    chooseFilesBtn.addEventListener("click", () => {
        fileInput.click();
    });

    // Display selected file names
    fileInput.addEventListener("change", () => {
        displayFileNames(fileInput.files);
    });

    // Display file names on the page horizontally
    function displayFileNames(files) {
        fileNamesDiv.innerHTML = ""; // Clear the previous file names
        fileNamesDiv.style.display = "flex"; // Use flexbox for horizontal layout
        fileNamesDiv.style.flexWrap = "wrap"; // Allow wrapping if names are too long
        fileNamesDiv.style.gap = "10px"; // Add spacing between items

        Array.from(files).forEach((file) => {
            const filename = file.name;
            const fileNameElement = document.createElement("span"); // Use span for inline display
            fileNameElement.textContent = filename;
            fileNameElement.style.padding = "5px";
            fileNameElement.style.border = "1px solid #ddd";
            fileNameElement.style.borderRadius = "5px";
            fileNameElement.style.backgroundColor = "#f9f9f9";
            fileNameElement.style.color = "#333";
            fileNamesDiv.appendChild(fileNameElement);
        });
    }




    form.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent default form submission
        const files = fileInput.files;

        if (files.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'No Files Selected',
                text: 'Please select files to upload.',
                showCancelButton: true,
                confirmButtonText: 'Choose Files',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    fileInput.click();
                }
            });
            return;
        }
        let totalFiles = files.length;
        let successfulUploads = 0;
        let failedUploads = 0;

        const countingContainer = document.getElementById("counting_container");
        countingContainer.style.fontFamily = "Poppins, sans-serif";
        updateUploadStatus();
        const urlParams = new URLSearchParams(window.location.search);
        const personId = urlParams.get("person_id");
        Array.from(files).forEach((file, index) => {
            const formData = new FormData();
            formData.append("files[]", file);
            formData.append("person_id", personId);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "{{ url('psychology_upload_image_file') }}", true);
            xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

            xhr.onload = () => {
                if (xhr.status === 200) {
                    successfulUploads++;
                } else {
                    failedUploads++;
                }
                updateUploadStatus();
                if (successfulUploads + failedUploads === totalFiles) {
                    Swal.fire({
                        icon: successfulUploads > 0 ? 'success' : 'error',
                        title: 'Upload Complete',
                        html: `
                            <p>Total Files: ${totalFiles}</p>
                            <p>Successfully Uploaded: ${successfulUploads}</p>
                            <p>Failed Uploads: ${failedUploads}</p>
                        `,
                    });

                    fileInput.value = "";
                    countingContainer.innerHTML = "";
                    fileNamesDiv.innerHTML = "";
                }
            };

            xhr.onerror = () => {
                failedUploads++;
                updateUploadStatus();
            };

            xhr.send(formData);
        });

        function updateUploadStatus() {
            countingContainer.innerHTML = `
                <p>Total Files: <strong>${totalFiles}</strong></p>
                <p>Successfully Uploaded: <strong>${successfulUploads}</strong></p>
                <p>Failed Uploads: <strong>${failedUploads}</strong></p>
            `;
        }

    });


    $("#psychologyBtn").click(function(){
    const urlParams = new URLSearchParams(window.location.search);
    const personId = urlParams.get("person_id");

    const formData = new FormData();
    formData.append("person_id", personId);
    formData.append("psychology_summary", $("#psychology_summary").val());

    $.ajax({
        url: "{{ url('psychology_summary') }}",
        type: "POST",
        dataType: 'json',
        contentType: false,
        processData: false,
        data: formData,
        beforeSend: function(xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        },
        success: function(response){
            if (response.success) {
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload(); 
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function(xhr, status, error){
            Swal.fire({
                title: "Error!",
                text: "Unable to save counseling summary. Please try again.",
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    });
});




</script>

@endsection




