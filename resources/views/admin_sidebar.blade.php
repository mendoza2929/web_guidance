<div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <div class="navbar-vertical-content scrollbar">
      <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
        <li class="nav-item">
          <!-- label-->
          <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
            <div class="col-auto navbar-vertical-label">Dashboard</div>
            <div class="col ps-0">
              <hr class="mb-0 navbar-vertical-divider" />
            </div>
          </div>
          <a class="nav-link {{ Request::is('admin/index') ? 'active' : '' }}" href="{{URL::to('admin/index')}}" role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar"></span></span><span class="nav-link-text ps-1">Student Records</span></div>
          </a>
          {{-- <a class="nav-link {{ Request::is('admin/chatbot') ? 'active' : '' }}" href="{{URL::to('admin/chatbot')}}" role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar"></span></span><span class="nav-link-text ps-1">Chat Bot</span></div>
          </a>
          <a class="nav-link {{ Request::is('admin/anecdotal') ? 'active' : '' }}" href="{{URL::to('admin/anecdotal')}}" role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar"></span></span><span class="nav-link-text ps-1">Anecdotal</span></div>
          </a>
          <a class="nav-link {{ Request::is('admin/counseling') ? 'active' : '' }}" href="{{URL::to('admin/counseling')}}" role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar"></span></span><span class="nav-link-text ps-1">Counseling</span></div>
          </a>
          <a class="nav-link {{ Request::is('admin/psychology') ? 'active' : '' }}" href="{{URL::to('admin/psychology')}}" role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar"></span></span><span class="nav-link-text ps-1">Aptitude Result</span></div>
          </a> --}}
          {{-- <a class="nav-link {{ Request::is('upload_image_file') ? 'active' : '' }}" href="{{URL::to('upload_image_file')}}" role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar"></span></span><span class="nav-link-text ps-1">Upload Image</span></div>
          </a>
          <a class="nav-link {{ Request::is('admin/import') ? 'active' : '' }}" href="{{URL::to('admin/import')}}" role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar"></span></span><span class="nav-link-text ps-1">Import</span></div>
          </a> --}}
          {{-- <a class="nav-link {{ Request::is('admin/import') ? 'active' : '' }}" href="{{URL::to('admin/import')}}" role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar"></span></span><span class="nav-link-text ps-1">Import</span></div>
          </a> --}}
        </li>
      </ul>
    </div>
  </div>