@include('layouts.header')
<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{asset('assets/img/ddtc_logo.png')}}" alt="">
        <h1 class="sitename"><span>D</span>DTC</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <!-- <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#features">Features</a></li>
          <li><a href="#pricing">Pricing</a></li> -->
          <!-- <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li> -->
          <!-- <li><a href="#contact">Contact</a></li> -->
          <li><a href="{{ route('logout') }}">Sign out</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-5">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h2><i class="bi bi-boxes"></i> Inventory Management System</h2>
            <div class="d-flex">
              {{-- <a href="starter-page.html" class="btn-get-started">Login</a> --}}
              <!-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a> -->
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2">
            <img src="assets/img/hero-img.png" class="img-fluid" alt="">
          </div>
        </div>
      </div>
      @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif
  
  @if (session('warning'))
      <div class="alert alert-warning">
          {{ session('warning') }}
      </div>
  @endif
  
  @if (session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
  @endif
      <div class="icon-boxes position-relative" data-aos="fade-up" data-aos-delay="200">
        <div class="container position-relative">
          <div class="row gy-4 mt-5">

            {{-- <div class="col-xl-3 col-md-6">
              <div class="icon-box">
                <div class="icon"><i class="bi bi-easel"></i></div>
                <h4 class="title"><a href="{{ route ('units.showroom')}}" class="stretched-link">Showroom Inventory</a></h4>
              </div>
            </div><!--End Icon Box --> --}}

            <div class="col-xl-3 col-md-6">
              <div class="icon-box">
                <div class="icon"><i class="bi bi-house-door-fill"></i></div>
                <h4 class="title"><a href="{{route ('whitehouse-dash')}}"  class="stretched-link">Inventory - DDTC</a></h4>
              </div>
            </div>
             <script>
              $(document).ready(function () {
                // Function to show toastr notification with a customizable style
                function showCustomToastr(type, message) {
                  toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: "3000"
                  };
            
                  if (type === "success") {
                    toastr.options.toastClass = "toast custom-success";
                  } else if (type === "error") {
                    toastr.options.toastClass = "toast custom-error";
                  } else if (type === "info") {
                    toastr.options.toastClass = "toast custom-info";
                  } else if (type === "warning") {
                    toastr.options.toastClass = "toast custom-warning";
                  }
            
                  toastr[type](message);
                }
            
                // Example usage on click
                $("#workingProcessLink").on("click", function (e) {
                  e.preventDefault(); // Prevent default behavior of the link
                  showCustomToastr("info", "Work on Progress...");
                });
              });
            </script> 
            
            <!--End Icon Box -->

            {{-- <div class="col-xl-3 col-md-6">
              <div class="icon-box">
                <div class="icon"><i class="bi bi-bar-chart-steps"></i></div>
                <h4 class="title"><a href="#" id="workingProcessLink" class="stretched-link">Stock Monitoring and Allocation</a></h4>
              </div>
            </div> 
            <!--End Icon Box --> --}}

            <!-- <div class="col-xl-3 col-md-6">
              <div class="icon-box">
                <div class="icon"><i class="bi bi-command"></i></div>
                <h4 class="title"><a href="" class="stretched-link">Nemo Enim</a></h4>
              </div>
            </div> -->
            <!--End Icon Box -->

          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <!-- <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <p class="who-we-are">Who We Are</p>
            <h3>Unleashing Potential with Creative Strategy</h3>
            <p class="fst-italic">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna aliqua.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo consequat.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Duis aute irure dolor in reprehenderit in voluptate velit.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</span></li>
            </ul>
            <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
          </div>

          <div class="col-lg-6 about-images" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">
              <div class="col-lg-6">
                <img src="assets/img/about-company-1.jpg" class="img-fluid" alt="">
              </div>
              <div class="col-lg-6">
                <div class="row gy-4">
                  <div class="col-lg-12">
                    <img src="assets/img/about-company-2.jpg" class="img-fluid" alt="">
                  </div>
                  <div class="col-lg-12">
                    <img src="assets/img/about-company-3.jpg" class="img-fluid" alt="">
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </section> -->
    <!-- /About Section -->

    <!-- Services Section -->
 
    
    <!-- /Services Section -->

    <!-- Features Section -->
   
    
    <!-- /Features Section -->

    <!-- Pricing Section -->
   <!-- /Pricing Section -->

    <!-- Faq Section -->
   <!-- /Faq Section -->

    <!-- Contact Section -->
   <!-- /Contact Section -->
 
   @include('layouts.footer')
 @include('layouts.script')

  </main>
 

</body>

</html>