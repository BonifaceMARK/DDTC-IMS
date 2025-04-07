{{-- <footer id="footer" class="footer light-background">
  <div class="container">
    <!-- <div class="copyright text-center ">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">eStartup</strong> <span>All Rights Reserved</span></p>
    </div>
    <div class="social-links d-flex justify-content-center">
      <a href=""><i class="bi bi-twitter-x"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
      <a href=""><i class="bi bi-linkedin"></i></a>
    </div> -->
    
  </div>
</footer> --}}

<!-- Scroll Top -->
<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-gear"></i></a>

<!-- Preloader -->
<div id="preloader">
  <img src="{{ asset('assets/img/ddtc_logo.png') }}" alt="Logo">
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const preloader = document.getElementById("preloader");
    setTimeout(() => {
      preloader.style.opacity = 0;
      preloader.style.visibility = "hidden";
    }, 1000); // Adjust delay as needed
  });
</script>
