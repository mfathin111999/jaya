<nav class="col-md-2 d-none d-md-block sidebar" style="height: auto; background-color: #ffc107; min-height: 100vh;">
  <div class="sidebar-sticky font-weight-bold">

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span class="font-weight-bold text-dark">MENU</span>
      <a class="d-flex align-items-center text-muted" href="#">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column" style="font-size: 12px;">
      <li class="nav-item">
        <a class="nav-link active text-white" href="{{ route('dashboard') }}">
          <i class="fa fa-home pr-2"></i>
          DASHBOARD <span class="sr-only"></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('calendar') }}">
          <i class="fa fa-calendar pr-2"></i>
          KALENDER
        </a>
      </li>
      <li class="nav-item">
        @if(session('role') == 5)
        <a class="nav-link text-white" href="{{ route('engagement_vendor') }}">
        @else
        <a class="nav-link text-white" href="{{ route('engagement') }}">
        @endif
          <i class="fa fa-calendar pr-2"></i>
          RESERVASI
        </a>
      </li>
      @if(session('role') == 5)
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('vendor.debt.card') }}">
          <i class="fa fa-calendar pr-2"></i>
          KARTU PIUTANG
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('vendor.payment.card') }}">
          <i class="fa fa-calendar pr-2"></i>
          PEMBAYARAN
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('engagement_history') }}">
          <i class="fa fa-calendar pr-2"></i>
          HISTORY
        </a>
      </li>
      @endif
      @if(session('role') == 1)
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('vendor') }}">
          <i class="fa fa-tasks pr-2"></i>
          PARTNER BISNIS
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('supervisor.debt.card.vendor') }}">
          <i class="fa fa-area-chart pr-2"></i>
          KARTU HUTANG
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('supervisor.debt.card.user') }}">
          <i class="fa fa-area-chart pr-2"></i>
          KARTU PIUTANG
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('supervisor.payment.vendor') }}">
          <i class="fa fa-area-chart pr-2"></i>
          PEMBAYARAN VENDOR
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('supervisor.payment.user') }}">
          <i class="fa fa-area-chart pr-2"></i>
          PEMBAYARAN CUSTOMER
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('adminservice') }}">
          <i class="fa fa-tags pr-2"></i>
          SERVICE
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('resource') }}">
          <i class="fa fa-tags pr-2"></i>
          RESOURCE
        </a>
      </li>
      @endif
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span class="font-weight-bold text-dark">PENGATURAN</span>
      <a class="d-flex align-items-center text-muted" href="#">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2" style="font-size: 12px;">
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('setting_account') }}">
          <i class="fa fa-cogs pr-2"></i> 
          PENGATURAN AKUN
        </a>
      </li>
      @if(session('role') == 1)
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('setting_user') }}">
          <i class="fa fa-cog pr-2"></i> 
          PENGELOLAAN USER
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('setting_application') }}">
          <i class="fa fa-wrench pr-2"></i> 
          PENGATURAN APLIKASI
        </a>
      </li>
      @endif
    </ul>
  </div>
</nav>