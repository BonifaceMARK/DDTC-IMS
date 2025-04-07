@include('layouts.header')

<body class="starter-page-page">

  <!-- Header -->
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="{{ url('/units-showroom') }}" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename"><span><i class="bi bi-laptop"></i> Units</span> Showroom</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
          {{-- Display authenticated user's name --}}
          @if(Auth::check())
          <li class="nav-item">
            <a href="#" class="nav-link">Welcome, {{ Auth::user()->fullname }}</a>
          </li>
          @endif
          {{-- <li><a href="{{ url('/about') }}">About</a></li> --}}
          <li><a href="{{ route('logout') }}">Sign out</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

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

   <!-- Content Section -->
<section id="starter-section" class="starter-section section">
  <div class="container-fluid section-title" style="padding: 0;" data-aos="fade-up">
    <!-- Panel with iFrame -->
    <div class="iframe-panel border rounded" style="height: 100%; background-color: transparent; padding: 2px;">
      <iframe id="iframeContent" src="{{ route('units.analytics') }}" style="width: 100%; height: 700px; border: none;"></iframe>
    </div>
  </div>
</section>

    @include('layouts.footer')
  </main>
 
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });
</script>

  <!-- Footer Navbar -->
<footer class="footer bg-dark text-white py-3" style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1000;">
    <div class="container d-flex justify-content-between">
        <nav class="nav">
            {{-- <a onclick="loadIframe('{{ route('units.analytics') }}')" class="btn mx-2 animated-link"><i class="bi bi-graph-up"></i> Analytics</a> --}}
            @auth
            @if (in_array(auth()->user()->role, [1, 2]))
                <a onclick="loadIframe('{{ route('view-units') }}')" class="btn mx-2 animated-link"><i class="bi bi-pc-display-horizontal"></i> Showroom Units</a>
            @endif
        @endauth
        
            {{-- @auth
            @if (auth()->user()->role == 1)
                <a onclick="loadIframe('{{ url('users') }}')" class="btn mx-2 animated-link">
                    <i class="bi bi-person-circle"></i> UserManagement
                </a>
            @endif
        @endauth --}}

        
        
        </nav>
    </div>
</footer>

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