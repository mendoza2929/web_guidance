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

		{{-- @include('admin_sidebar'); --}}

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

        {{-- <div class="card mb-3" id="chat-container">
            <div class="card-body">
        
                </div>
            </div>
        </div> --}}
        
          
        <iframe id="JotFormIFrame-019532d807e47f4fb9ab8bcb18e2b2c005ed"
        title="Chatbot: School Guidance Assistant" onload="window.parent.scrollTo(0,0)"
        allowtransparency="true" allow="geolocation; microphone; camera; fullscreen"
        src="https://agent.jotform.com/019532d807e47f4fb9ab8bcb18e2b2c005ed?embedMode=iframe&background=1&shadow=1"
        frameborder="0" style="
          min-width:100%;
          max-width:100%;
          height:688px;
          border:none;
          width:100%;
        " scrolling="no">
</iframe>
<script src='https://cdn.jotfor.ms/s/umd/latest/for-form-embed-handler.js'></script>
<script>
  window.jotformEmbedHandler("iframe[id='JotFormIFrame-019532d807e47f4fb9ab8bcb18e2b2c005ed']",
    "https://www.jotform.com");
    

  // Listen for messages from the iframe
  window.addEventListener('message', function(event) {
    if (event.origin !== "https://agent.jotform.com") return;

    console.log("Full event data:", event.data); // Debugging output

    const data = event.data?.message || {};
    console.log("Extracted data:", data); // See if it's extracting correctly

    // Extract message from response object if available
    const responseMessage = data?.response?.message || data?.message || null;
    console.log("Extracted responseMessage:", responseMessage); 

    if (!responseMessage) return; // Prevent sending empty messages

    let previousQuestion = sessionStorage.getItem('lastQuestion') || "Unknown question";
    sessionStorage.setItem('lastQuestion', responseMessage);

    $.ajax({
        url: "{{ url('save-conversation') }}",
        type: 'POST',
        data: {
            question: previousQuestion,  
            response: responseMessage,  
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            console.log('Saved successfully:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error saving message:', error);
        }
    });
});


</script>

        
          
		  



@stop

@section('scripts')
<script src='https://cdn.jotfor.ms/s/umd/latest/for-embedded-agent.js'></script>
<script>

// window.addEventListener("DOMContentLoaded", function() {
//     window.AgentInitializer.init({
//       agentRenderURL: "https://agent.jotform.com/019532d807e47f4fb9ab8bcb18e2b2c005ed",
//       rootId: "JotformAgent-019532d807e47f4fb9ab8bcb18e2b2c005ed",
//       formID: "019532d807e47f4fb9ab8bcb18e2b2c005ed",
//       queryParams: ["skipWelcome=1", "maximizable=1"],
//       domain: "https://www.jotform.com",
//       isDraggable: false,
//       background: "linear-gradient(180deg, #2462BA 0%, #2462BA 100%)",
//       buttonBackgroundColor: "#02357D",
//       buttonIconColor: "#FFF",
//       variant: false,
//       customizations: {
//         "greeting": "Yes",
//         "greetingMessage": "Hi! How can I assist you?",
//         "pulse": "Yes",
//         "position": "right"
//       },
//       isVoice: undefined,
//       onMessageSent: function(message) {
//         // Send the user's question to the Laravel backend
//         fetch('/save-chat', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Add CSRF token for Laravel
//             },
//             body: JSON.stringify({
//                 question: message,
//                 response: null // You can update this later with the AI's response
//             })
//         })
//         .then(response => response.json())
//         .then(data => console.log(data))
//         .catch(error => console.error('Error:', error));
//       }
//     });
// });



    

// $(document).ready(function() {
    

//     setTimeout(function() {
//         $("#chat-box").append(`<div class="message bot">Hello! How can I assist you today?</div>`);
//         scrollToBottom();
//     }, 1000);

//     $("#chatBotForm").submit(function(event) {
//         event.preventDefault();
//         sendMessage();
//     });

//     $("#faq-select").change(function() {
//         let selectedQuestion = $(this).val();
//         if (selectedQuestion !== "") {
//             $("#user-input").val(selectedQuestion);
//             sendMessage();
//             $(this).val(""); 
//         }
//     });

//     $("#close-btn").click(function() {
//         $("#chat-container").fadeOut();
//     });

//     function sendMessage() {
//         let userMessage = $("#user-input").val().trim();
//         if (userMessage === "") return;

//         $("#chat-box").append(`<div class="message user">${userMessage}</div>`);
//         $("#user-input").val("");

//         let formData = new FormData();
//         formData.append("_token", "{{ csrf_token() }}");
//         formData.append("question", userMessage);

//         $.ajax({
//             url: "{{ url('chatbot') }}",
//             type: "POST",
//             data: formData,
//             processData: false,
//             contentType: false,
//             success: function(response) {
//                 $("#chat-box").append(`<div class="message bot">${response.response}</div>`);
//                 scrollToBottom();
//             },
//             error: function() {
//                 $("#chat-box").append(`<div class="message bot">Sorry, something went wrong.</div>`);
//                 scrollToBottom();
//             }
//         });
//     }

//     function scrollToBottom() {
//         $(".chat-box").animate({ scrollTop: $(".chat-box")[0].scrollHeight }, 500);
//     }
// });


</script>

@stop





