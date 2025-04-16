@include('layouts.header')

<body class="starter-page-page">
  
<!-- Header -->
<header id="header" class="header d-flex align-items-center sticky-top" style="padding: 0 0; font-size: 14px;">
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
    <a href="{{ url('/units-showroom') }}" class="logo d-flex align-items-center">
      <!-- Uncomment the line below if you wish to use an image logo -->
      <!-- <img src="assets/img/logo.png" alt=""> -->
      <h1 class="sitename" style="font-size: 15px; margin: 0;"><span><i class="bi bi-house-door-fill"></i> Stock</span>Inventory</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul style="margin: 0; padding: 0;">
        <li><a style="font-size: 10px;" href="{{ url('/') }}">Home</a></li>
        @if(Auth::check())
        <li class="nav-item">
          <a href="#" class="nav-link" style="font-size: 10px;">Welcome, {{ Auth::user()->fullname }}</a>
        </li>
        @endif
        {{-- <li><a href="{{ url('/about') }}">About</a></li> --}}
        <li>
          <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" style="font-size: 10px;">Sign out</a>
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
  <main class="main container-fluid" >
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

    <section id="starter-section" style="height: 800px; margin: 0; padding: 0; width: 100%; margin-bottom:100px; ">
      <div class="container-fluid section-title" style="padding: 0; height: 100%; " data-aos="fade-up">
        <!-- Panel with iFrame -->
        <div class="iframe-panel border rounded " style="height: 100%; background-color: transparent; padding: 0; margin-bottom:150px;">
          <iframe 
            id="iframeContent" 
            src="{{ route('view.whitehouse') }}" 
            style="width: 100%; height: 100%; border: none; ">
          </iframe>
        </div>
      </div>
    </section>
    
    
    @include('layouts.footer')
  </main>
 
 
<!-- Footer Navbar -->
<footer class="footer text-white py-2" style="position: fixed; bottom: 0; left: 0; width: 100%; background-color: white; z-index: 1000; border-top: 1px solid #ddd;">
  <div class="container d-flex justify-content-between">
    <nav class="nav">
      @auth
      @if (in_array(auth()->user()->role, [1, 2]))
        <a 
          onclick="loadIframe('{{ route('view.whitehouse') }}')" 
          class="btn mx-2 animated-link" 
          style="font-size: 12px; color: black; text-decoration: none; padding: 5px 10px; transition: color 0.3s, background-color 0.3s;"
          onmouseover="this.style.color='white'; this.style.backgroundColor='green';"
          onmouseout="this.style.color='black'; this.style.backgroundColor='transparent';"
        >
          <i class="bi bi-house-door-fill"></i> Stock Inventory
        </a>
 
      @endif
      @endauth

      <a 
      onclick="loadIframe('https://docs.google.com/spreadsheets/d/1OjU9sD3nUKrfOn8HnGNFZaD_hlfb0BJc2tQpwO-Eqrk/edit?gid=1916401074#gid=1916401074')" 
      class="btn mx-2 animated-link" 
      style="font-size: 12px; color: black; text-decoration: none; padding: 5px 10px; transition: color 0.3s, background-color 0.3s;"
      onmouseover="this.style.color='white'; this.style.backgroundColor='green';"
      onmouseout="this.style.color='black'; this.style.backgroundColor='transparent';"
    >
    <i class="bi bi-google"></i> Spreadsheet
    </a>

      @auth
      @if (in_array(auth()->user()->role, [1, 2]))
      <a 
      onclick="loadIframe('{{ url('users') }}')" 
      class="btn mx-2 animated-link" 
      style="font-size: 12px; color: black; text-decoration: none; padding: 5px 10px; transition: color 0.3s, background-color 0.3s;"
      onmouseover="this.style.color='white'; this.style.backgroundColor='green';"
      onmouseout="this.style.color='black'; this.style.backgroundColor='transparent';"
    >
    <i class="bi bi-person-standing"></i> User Management
    </a>
    @endif
      @endauth
      {{-- <a 
      onclick="loadIframe('{{ route('dashboard.analytics') }}')" 
      class="btn mx-2 animated-link" 
      style="font-size: 12px; color: black; text-decoration: none; padding: 5px 10px; transition: color 0.3s, background-color 0.3s;"
      onmouseover="this.style.color='white'; this.style.backgroundColor='green';"
      onmouseout="this.style.color='black'; this.style.backgroundColor='transparent';"
    >
    <i class="bi bi-graph-up"></i> Dashboard
    </a> --}}
    </nav>
  </div>
</footer>

 {{-- FOR IFRAME LOADING     --}}
 <script>
  document.addEventListener('DOMContentLoaded', function () {
   const iframe = document.getElementById('iframeContent');
   if (iframe) {
     iframe.addEventListener('load', function () {
       console.log('iFrame loaded successfully!');
     });
   } else {
     console.error('iFrame not found!');
   }
 
   const header = document.getElementById('header');
   if (header) {
     window.addEventListener('scroll', function() {
       if (window.scrollY > 50) {
         header.classList.add('scrolled');
       } else {
         header.classList.remove('scrolled');
       }
     });
   } else {
     console.error('Header element not found!');
   }
 });
 
 function loadIframe(url) {
   console.log("Loading iframe with URL:", url); 
   const iframe = document.getElementById('iframeContent');
   if (iframe) {
     iframe.src = url;
   } else {
     console.error('iFrame not found!');
   }
 }
   </script>
  @include('layouts.script')

</body>
</html>