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

		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <div class="card mb-3">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Aptitude Test</h5>
                    </div>
                </div>
            </div>
        </div>
 
        <div class="card mb-3">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Aptitude Test</h5>
                    </div>
                    <div class="col-md-auto">
                        <div class="d-flex align-items-center">
                            <span class="me-2">Time remaining:</span>
                            <div class="fs-1 text-primary" id="timer">30:00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    
                    <div class="question-container">
                        <h4 class="question-number">Question {{ $currentIndex + 1 }} of {{ $totalQuestions }}</h4>
                        <div class="question-text mb-4">
                            {{ $question->question }}
                        </div>
                        
                        <div class="choices-container">
                            @foreach($choices as $choice)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" 
                                       name="answer" id="choice{{ $choice->id }}" 
                                       value="{{ $choice->id }}">
                                <label class="form-check-label" for="choice{{ $choice->id }}">
                                    {{ $choice->choices }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    {{-- <div class="navigation-buttons mt-4">
                        @if($currentIndex > 0)
                        <a href="{{ route('aptitude.question', ['id' => Session::get('aptitude_question_ids')[$currentIndex - 1]]) }}" 
                           class="btn btn-secondary">Previous</a>
                        @endif
                        
                        @if($currentIndex < $totalQuestions - 1)
                        <button type="submit" class="btn btn-primary float-end">Next</button>
                        @else
                        <button type="submit" class="btn btn-success float-end">Submit Test</button>
                        @endif
                    </div> --}}
                </form>
            </div>
        </div>



@section('scripts')
<script>
    // Timer functionality
    function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                timer = duration;
                // Auto-submit when time is up
                window.location.href = "{{ route('aptitude.submit') }}";
            }
        }, 1000);
    }

    window.onload = function () {
        var thirtyMinutes = 60 * 30,
            display = document.querySelector('#timer');
        startTimer(thirtyMinutes, display);
    };
</script>

@stop





