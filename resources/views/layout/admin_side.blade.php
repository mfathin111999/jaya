<nav class="col-md-2 d-none d-md-block bg-light sidebar" style="height: 100vh;">
  <div class="sidebar-sticky">

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Menu</span>
      <a class="d-flex align-items-center text-muted" href="#">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="{{ route('dashboard') }}">
          <i class="fa fa-home pr-2"></i>
          Dashboard <span class="sr-only"></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('calendar') }}">
          <i class="fa fa-calendar pr-2"></i>
          Calendar
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('engagement') }}">
          <i class="fa fa-calendar pr-2"></i>
          Engagements
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('work') }}">
          <i class="fa fa-tasks pr-2"></i>
          Works
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('report') }}">
          <i class="fa fa-clipboard pr-2"></i>
          Reports
        </a>
      </li>
      {{--<li class="nav-item">
        <a class="nav-link" href="{{ route('survei') }}">
          <i class="fa fa-clipboard pr-2"></i>
          Survey Report
        </a>
      </li>--}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('statistic') }}">
          <i class="fa fa-area-chart pr-2"></i>
          Statistic
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('adminservice') }}">
          <i class="fa fa-tags pr-2"></i>
          Service
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('resource') }}">
          <i class="fa fa-tags pr-2"></i>
          Resources
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Setting</span>
      <a class="d-flex align-items-center text-muted" href="#">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('setting_user') }}">
          <i class="fa fa-cog pr-2"></i> 
          Setting User
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('setting_account') }}">
          <i class="fa fa-cogs pr-2"></i> 
          Setting Account
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('setting_application') }}">
          <i class="fa fa-wrench pr-2"></i> 
          Setting Application
        </a>
      </li>
    </ul>
  </div>
</nav>