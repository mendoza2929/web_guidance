@extends('site/layouts/main')
@stop


@section('content')

<style>
  .holiday {
    background-color: red !important;
    color: white !important;
  }
  .container-fluid{
    background-color: #ffffff;
  }
  .navbar{
    background-color: #ffffff;
  }
  .navbar-vertical-content {
    background-color: #ffffff;
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
                  <h5 class="mb-2 mb-md-0">Aptituted Data</h5>
                </div>
              </div>
            </div>
          </div>
          
            <div class="row">
              <div class="col-md-3">
                  <label for="classification_id">Department Type</label>
                  <select name="classification_id" id="classification_id" class="form-control">
                      <option value="">Select Classification</option>
                      @foreach ($classification_list as $classification)
                          <option value="{{ $classification->id }}">{{ $classification->classification_name }}</option>
                      @endforeach
                  </select>
              </div>
          
              <div class="col-md-3">
                  <label for="classification_level_id">Level</label>
                  <select name="classification_level_id" id="classification_level_id" class="form-control">

                  </select>
              </div>
          </div>
          
          <br>

          <div class="card">
            <div class="card-body">
                <h5 class="card-title">Aptitude Data Sheet</h5>
                <table id="studentTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Department Type</th>
                            <th>Level</th>
                            {{-- <th>Image</th>
                            <th>Summary</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>



        
          <!-- Image Modal -->
 <!-- Modal Structure -->
<div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Psychology Image</h5>
          </div>
          <div class="modal-body text-center">
              <img id="modalImage" src="" class="img-fluid" alt="Anecdotal Image">
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>


        



@stop

@section('scripts')
<script>
 var oTable;
 $(document).ready(function () {
    var oTable = $("#studentTable").DataTable({
        ajax: {
            url: "{{ url('psychology/data_sheet') }}",
            type: "GET",
            data: function(d) {
                d.classification_id = $('#classification_id').val();
                d.classification_level_id = $('#classification_level_id').val();
            },
            dataSrc: "",
        },
        columns: [
            {
                data: 'name',
            },
            {
                data: 'classification',
            },
            {
                data: 'level',
            }
            // {
            //     data: 'img',
            // }, 
            // {
            //     data: 'summary',
            // }, 
        ]
    });


    $('#classification_id').on('change', function () {
        var classificationId = $(this).val();
        $('#classification_level_id').empty().append('<option value="">Loading...</option>');

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
                }
            });
        } else {
            $('#classification_level_id').empty().append('<option value="">Select Classification Level</option>');
        }

        oTable.ajax.reload(); 
    });


    $('#classification_level_id').on('change', function () {
        oTable.ajax.reload();
    });

    oTable.on("click", ".viewDetail", function() {
        const person_id = $(this).data("person_id");
        const url = "{{ url('admin/psychology_data') }}?person_id=" + person_id;
        window.open(url);
    });

    $(document).on("click", ".viewImage", function (e) {
      e.preventDefault();
      var imgSrc = $(this).data("img");

      if (imgSrc) {
          $("#modalImage").attr("src", imgSrc);
          $("#imageModal").modal("show");
      }
  });

  


});


</script>

@stop





