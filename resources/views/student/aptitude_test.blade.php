@extends('site/layouts/main')
@stop


@section('content')

<style>
#chat-container {
    width: 350px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    background: #ffffff;
    position: fixed;
    bottom: 20px;
    right: 20px;
    overflow: hidden;
    border: 1px solid #ddd;
}

.chat-header {
    background: #007bff;
    color: #fff;
    padding: 12px;
    font-size: 16px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.close-btn {
    cursor: pointer;
    font-size: 20px;
}

.chat-box {
    height: 300px;
    overflow-y: auto;
    padding: 10px;
    background-color: #f8f9fa;
    display: flex;
    flex-direction: column;
}

.message {
    padding: 8px 12px;
    margin: 5px;
    border-radius: 8px;
    max-width: 75%;
    word-wrap: break-word;
    font-size: 14px;
}

.bot {
    background-color: #e3f2fd;
    align-self: flex-start;
}

.user {
    background-color: #d1f2eb;
    align-self: flex-end;
    text-align: right;
}

/* FAQ Select Dropdown */
.faq-list {
    padding: 10px;
    background: #ffffff;
    border-top: 1px solid #ddd;
}

.faq-list select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    outline: none;
    transition: 0.3s;
}

.faq-list select:hover {
    border-color: #007bff;
}

/* Chat Input Box */
.chat-input {
    display: flex;
    padding: 10px;
    background: #ffffff;
    border-top: 1px solid #ddd;
}

.chat-input input {
    flex: 1;
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 14px;
}

/* Send Button */
.chat-input button {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 8px 15px;
    margin-left: 5px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    font-size: 14px;
}

.chat-input button:hover {
    background: #0056b3;
}
.card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-check-input {
            margin-right: 10px;
        }
        .btn-nav {
            padding: 10px 20px;
        }
        .btn-prev {
            background-color: #6c757d;
            color: white;
        }
        .btn-next {
            background-color: #28a745;
            color: white;
        }
        .question-nav .btn {
        width: 40px;
        text-align: center;
    }
    .form-check:hover {
        background-color: #f8f9fa;
    }
    .btn-nav {
        min-width: 100px;
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

		@include('student_sidebar');

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


        <div class="card mb-3">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Aptitude Test</h5>
                    </div>
                </div>
            </div>
        </div>
 
        <div class="container mt-5">
            <div class="card mb-3">
                <form id="aptitudeForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="question_id" value="{{ $questions[$current_question_index]['id'] }}">
                    <input type="hidden" name="current_question_index" value="{{ $current_question_index }}">
                    <div class="card-body">
                        <h5 class="mb-2">Aptitude Test</h5>
                        <!-- Progress Bar -->
                        <div class="progress mb-3">
                            <div class="progress-bar bg-primary" role="progressbar" 
                                 style="width: {{ (($current_question_index + 1) / $total_questions) * 100 }}%" 
                                 aria-valuenow="{{ $current_question_index + 1 }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="{{ $total_questions }}">
                                {{ $current_question_index + 1 }} / {{ $total_questions }} ({{ number_format((($current_question_index + 1) / $total_questions) * 100, 0) }}%)
                            </div>
                        </div>
        
                        <!-- Question Navigation -->
                        <div class="question-nav mb-3 d-flex justify-content-center">
                            @for ($i = 0; $i < $total_questions; $i++)
                                <a href="{{ route('aptitude.test') }}?start=true&question={{ $i }}" 
                                   class="btn btn-sm {{ $i == $current_question_index ? 'btn-primary' : 'btn-outline-primary' }} mx-1">
                                    {{ $i + 1 }}
                                </a>
                            @endfor
                        </div>
        
                        @if (isset($questions[$current_question_index]))
                            <div class="question mt-4">
                                <p><strong>{{ $current_question_index + 1 }}.</strong> {{ $questions[$current_question_index]['question'] }}</p>
                                @foreach ($questions[$current_question_index]['choices'] as $index => $choice)
                                    <div class="form-check mb-2 p-2 rounded {{ session('answers.' . $questions[$current_question_index]['id']) == $choice['id'] ? 'bg-light border border-primary' : '' }}">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="answer" 
                                               id="choice_{{ $choice['id'] }}" 
                                               value="{{ $choice['id'] }}"
                                               {{ session('answers.' . $questions[$current_question_index]['id']) == $choice['id'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="choice_{{ $choice['id'] }}">
                                            {{ chr(65 + $index) }}. {{ $choice['choice'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="navigation mt-4 d-flex justify-content-between">
                                @if ($current_question_index > 0)
                                    <button type="button" class="btn btn-outline-secondary btn-nav" onclick="navigate({{ $current_question_index - 1 }})">Previous</button>
                                @else
                                    <span></span>
                                @endif
                                @if ($current_question_index < $total_questions - 1)
                                    <button type="button" class="btn btn-primary btn-nav" onclick="navigate({{ $current_question_index + 1 }})">Next</button>
                                @else
                                    <button type="submit" class="btn btn-success btn-nav" id="submit">Submit Test</button>
                                @endif
                            </div>
                        @else
                            <p>No questions available.</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>



@section('scripts')
<script>
 
 $(document).ready(function() {
    let answers = {};

    // Load previously selected answers
    $.get('{{ url("aptitude-test/answers") }}', function(response) {
        answers = response.answers || {};
        updateRadioButtons();
    });

    // Handle radio button changes
    $('input[name="answer"]').change(function() {
        const questionId = $('input[name="question_id"]').val();
        const answerId = $(this).val();
        saveAnswer(questionId, answerId);
    });

    // Save answer function
    function saveAnswer(questionId, answerId) {
        answers[questionId] = answerId;
        $.post('{{ url("aptitude-test/save-answer") }}', {
            _token: '{{ csrf_token() }}',
            question_id: questionId,
            answer: answerId
        }, function(response) {
            if (!response.success) {
                console.error('Failed to save answer');
            }
        });
    }

    // Form submission
    $("#aptitudeForm").submit(function(e) {
        e.preventDefault();

        const totalQuestions = {{ $total_questions }};
        const answeredQuestions = Object.keys(answers).length;

        if (answeredQuestions < totalQuestions) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Test',
                text: `You have answered ${answeredQuestions} out of ${totalQuestions} questions. Please answer all questions before submitting.`,
            });
            return;
        }

        $.ajax({
            url: '{{ url("aptitude_submit") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                answers: answers
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Test Completed!',
                        text: response.message,
                        timer: 3000
                    }).then(() => {
                        window.location.href = '{{ url("aptitude-test/results") }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: response.message,
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while submitting.',
                });
            }
        });
    });

    // Navigation function
    window.navigate = function(index) {
        const questionId = $('input[name="question_id"]').val();
        const selectedAnswer = $('input[name="answer"]:checked').val();

        if (selectedAnswer) {
            saveAnswer(questionId, selectedAnswer);
        }

        window.location.href = '{{ url("aptitude-test") }}?start=true&question=' + index;
    };

    function updateRadioButtons() {
        const questionId = $('input[name="question_id"]').val();
        if (answers[questionId]) {
            $(`input[value="${answers[questionId]}"]`).prop('checked', true);
            $(`input[value="${answers[questionId]}"]`).closest('.form-check').addClass('bg-light border border-primary');
        }
    }
});
</script>
@stop





