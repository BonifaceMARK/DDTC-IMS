@include('layouts.header')

<body class="starter-page-page">
  
  <!-- Header -->
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="{{ url('/units-showroom') }}" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename"><span><i class="bi bi-house-door-fill"></i> Stock</span>Inventory</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
          @if(Auth::check())
          <li class="nav-item">
            <a href="#" class="nav-link">Welcome, {{ Auth::user()->fullname }}</a>
          </li>
          @endif
          {{-- <li><a href="{{ url('/about') }}">About</a></li> --}}
          <li>
            <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Sign out</a>
        </li>
        
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>
  <!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              Are you sure you want to log out?
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <a href="{{ route('logout') }}" class="btn btn-danger">Log Out</a>
          </div>
      </div>
  </div>
</div>


  <!-- Main Content -->
  <main class="main">
    {{-- <div class="page-title" data-aos="fade">
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{url('/')}}">Home</a></li>
            <li class="current">Units</li>
          </ol>
        </div>
      </nav>
    </div> --}}

    <section id="starter-section" style="height: 700px;">
      <div class="container-fluid section-title" style="padding: 0; height: 100%;" data-aos="fade-up">
        <!-- Panel with iFrame -->
        <div class="iframe-panel border rounded" style="height: 100%; background-color: transparent; padding: 2px;">
          <iframe 
            id="iframeContent" 
            src="{{ route('view.whitehouse') }}" 
            style="width: 100%; height: 100%; border: none; scrolling:no;">
          </iframe>
        </div>
      </div>
    </section>
    
    
    @include('layouts.footer')
  </main>
 
 

  <!-- Footer Navbar -->
<footer class="footer bg-dark text-white py-3" style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1000;">
    <div class="container d-flex justify-content-between">
        <nav class="nav">
             {{-- <a onclick="loadIframe('{{ route('units.analytics') }}')" class="btn mx-2 animated-link"><i class="bi bi-graph-up"></i> Analytics</a>  --}}
            @auth
            @if (in_array(auth()->user()->role, [1, 2]))
                <a onclick="loadIframe('{{ route('view.whitehouse') }}')" class="btn mx-2 animated-link"><i class="bi bi-house-door-fill"></i> Stock Inventory</a>
            @endif
        @endauth
        
            {{-- @auth
            @if (auth()->user()->role == 1)
                <a onclick="loadIframe('{{ url('users') }}')" class="btn mx-2 animated-link">
                    <i class="bi bi-person-circle"></i> UserManagement
                </a>
            @endif
        @endauth  --}}
        </nav>
    </div>
</footer>

 
  @include('layouts.script')

</body>
</html>