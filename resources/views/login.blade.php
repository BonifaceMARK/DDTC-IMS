@include('layouts.header')

<body>
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <!-- Login Card Section -->
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="card shadow-lg mb-4 rounded-3">
                        <div class="card-body">
                            <!-- Logo Section -->
                            <div class="text-center pt-4 pb-2">
                                <a href="/" class="logo d-flex flex-column align-items-center">
                                    <img src="{{ asset('assets/img/ddtc_logo.png') }}" alt="DDTC Logo" style="max-height: 60px;">
                                    <h5 class="card-title text-center pb-0 fs-4 mt-3">Welcome to <SPAN>DDTC</SPAN> IT Solutions Inventory</h5>
                                </a>
                                <p class="text-center small">Enter your username & password to login</p>
                            </div>

                            <!-- Login Form -->
                            <form action="{{ route('Login') }}" method="POST" class="row g-3 needs-validation" novalidate id="lgonfrm">
                                @csrf
                                <!-- Success Message -->
                                @if(session('success'))
                                    <div class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                
                                <!-- Error Message -->
                                @if(session()->has('errors'))
                                    <div class="alert alert-danger text-center">
                                        <i class="bi bi-exclamation-circle"></i> {{ session('errors') }}
                                    </div>
                                @endif

                                <!-- Username Field -->
                                <div class="col-12">
                                    <label for="username" class="form-label" style="font-size: 12px;">Username</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="username" class="form-control" id="username" style="font-size: 12px;" required placeholder="Enter your username">
                                        <div class="invalid-feedback">Please enter your username!</div>
                                    </div>
                                </div>

                                <!-- Password Field -->
                                <div class="col-12">
                                    <label for="password" class="form-label" style="font-size: 12px;">Password</label>
                                    <input type="password" name="password" class="form-control" id="yourPassword" style="font-size: 12px;" required placeholder="Enter your password">
                                    <div class="invalid-feedback">Please enter your password!</div>
                                </div>
                                
                                <!-- Recaptcha Field -->
                                <div>
                                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Carousel Section -->
                <div class="col-lg-8 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex flex-grow-1 align-items-center">
                        <div id="carouselExampleCaptions" class="carousel slide rounded shadow-lg" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('assets/img/login-slide4.jpg') }}" class="d-block w-100" alt="Slide Image 1">
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>"The stock market is filled with individuals who know the price of everything, but the value of nothing." - Philip Fisher</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/img/login-slide2.jpg') }}" class="d-block w-100" alt="Slide Image 2">
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>"It does not matter how slowly you go as long as you do not stop." - Confucius</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/img/login-slide3.jpg') }}" class="d-block w-100" alt="Slide Image 3">
                                    <div class="carousel-caption d-none d-md-block">
                                        <p>"Science is organized knowledge. Wisdom is organized life." - Immanuel Kant</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('layouts.footer')
    @include('layouts.script')
</body>
</html>
