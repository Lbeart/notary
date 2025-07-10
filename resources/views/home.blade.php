<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noterët | Faqja Kryesore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
       .hero-slide {
    position: relative;
    height: 100vh;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
}
.overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: rgba(0, 0, 0, 0.6);
}
.hero-content {
    position: relative;
    z-index: 2;
}
.highlight {
    background-color: #fcb900;
    padding: 0 4px;
    color: white;
}
.service-card {
    transition: all 0.4s ease-in-out;
    cursor: pointer;
}
.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
}
.read-more {
    transition: all 0.3s ease-in-out;
}
.service-card:hover .read-more {
    text-decoration: underline;
}
.notary-cta {
    position: relative;
    overflow: hidden;
}
.notary-cta .overlay {
    background-color: rgba(0, 0, 0, 0.6);
}

    </style>
</head>
<body>

    <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">
            <img src="/img/logo.png" alt="Logo" height="40"> Notariz
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-3">
                <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Pages</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>

                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                @endguest

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>

            <a href="#" class="btn btn-warning text-white fw-bold">
                <i class="bi bi-chat-dots-fill me-1"></i> (+383) 44 999 999
            </a>
        </div>
    </div>
</nav>

    
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="hero-slide" style="background-image: url('/img/hero-bg1.jpg');">
                <div class="overlay"></div>
                <div class="container text-white text-center hero-content">
                    <h1 class="display-5 fw-bold">
                        Professional and Reliable <span class="highlight">Notary Service</span><br> That You Can Trust
                    </h1>
                    <p class="mt-3">Shërbim profesional, i besueshëm dhe i shpejtë për nevojat tuaja ligjore.</p>
                    <a href="#notaries" class="btn btn-warning mt-4 fw-bold px-4 py-2">Get Started</a>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
            <div class="hero-slide" style="background-image: url('/img/hero-bg2.jpg');">
                <div class="overlay"></div>
                <div class="container text-white text-center hero-content">
                    <h1 class="display-5 fw-bold">
                        Këshillim Ligjor nga <span class="highlight">Ekspertët Më të Mirë</span><br> Çdo Ditë për Ju
                    </h1>
                    <p class="mt-3">Zgjidhje të qarta, të shpejta dhe të sigurta nga noterët profesionistë.</p>
                    <a href="#notaries" class="btn btn-warning mt-4 fw-bold px-4 py-2">Rezervo Tani</a>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item">
            <div class="hero-slide" style="background-image: url('/img/hero-bg3.jpg');">
                <div class="overlay"></div>
                <div class="container text-white text-center hero-content">
                    <h1 class="display-5 fw-bold">
                        Shërbime <span class="highlight">Noteriale Digjitale</span><br> Direkt nga Pajisja Juaj
                    </h1>
                    <p class="mt-3">Nënshkruani kontrata online pa pasur nevojë të vini në zyrë.</p>
                    <a href="#notaries" class="btn btn-warning mt-4 fw-bold px-4 py-2">Provo Tani</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Prapa</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Para</span>
    </button>
</div>


<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Images -->
            <div class="col-lg-6 d-flex flex-wrap gap-3 mb-4 mb-lg-0">
                <div class="w-100">
                    <img src="/img/notary-1.jpg" alt="Notary Image 1" class="img-fluid rounded shadow-sm">
                </div>
                <div class="w-100 d-flex justify-content-between align-items-center mt-3">
                    <img src="/img/notary-2.jpg" alt="Notary Image 2" class="img-fluid rounded shadow-sm me-2" style="width: 48%;">
                    <div class="bg-light p-4 rounded text-center shadow-sm" style="width: 48%;">
                        <div class="mb-2">
                            <i class="bi bi-people-fill fs-2 text-warning"></i>
                        </div>
                        <h4 class="fw-bold text-primary">2,250+</h4>
                        <p class="mb-0 small text-muted">Trusted Clients</p>
                    </div>
                </div>
            </div>

            <!-- Right Content -->
            <div class="col-lg-6">
                <p class="text-warning fw-bold mb-1">Welcome To Notariz</p>
                <h2 class="fw-bold text-dark mb-4">We Are A Notary Public<br>That Travels To You</h2>
                <p class="text-muted mb-4">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                </p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Duis aute irure dolor in reprehenderit in voluptate velit esse</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Quis nostrud exercitation ullamco laboris nisi minim veniam</li>
                    <li><i class="bi bi-check-circle-fill text-warning me-2"></i> Nostrum exercitationem ullam corporis suscipit laboriosam</li>
                </ul>
                <a href="#about" class="btn btn-warning fw-bold text-white px-4 py-2">ABOUT US</a>
            </div>
        </div>
    </div>
</section>


<section class="py-5" style="background-color: #061539;">
    <div class="container text-center text-white">
        <p class="text-warning fw-bold mb-2">Practice Areas</p>
        <h2 class="fw-bold mb-3">We Serve The Best Service</h2>
        <p class="mb-5 text-white-50">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod<br>
            tempor incididunt ut labore et dolore magna aliqua
        </p>

        <div class="row g-4">
            <!-- CARD 1 -->
            <div class="col-md-4">
                <div class="service-card bg-white text-dark p-4 h-100 text-start rounded position-relative overflow-hidden">
                    <h5 class="fw-bold">Mobile Notary</h5>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                    <a href="#" class="read-more text-dark fw-bold text-decoration-none">
                        READ MORE <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <i class="bi bi-file-earmark-text position-absolute bottom-0 end-0 opacity-10 pe-3 pb-3 fs-1"></i>
                </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-md-4">
                <div class="service-card bg-white text-dark p-4 h-100 text-start rounded position-relative overflow-hidden">
                    <h5 class="fw-bold">Business Documents</h5>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                    <a href="#" class="read-more text-dark fw-bold text-decoration-none">
                        READ MORE <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <i class="bi bi-handshake position-absolute bottom-0 end-0 opacity-10 pe-3 pb-3 fs-1"></i>
                </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-md-4">
                <div class="service-card bg-white text-dark p-4 h-100 text-start rounded position-relative overflow-hidden">
                    <h5 class="fw-bold">Real Estate Forms</h5>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                    <a href="#" class="read-more text-dark fw-bold text-decoration-none">
                        READ MORE <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <i class="bi bi-buildings position-absolute bottom-0 end-0 opacity-10 pe-3 pb-3 fs-1"></i>
                </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-md-4">
                <div class="service-card bg-white text-dark p-4 h-100 text-start rounded position-relative overflow-hidden">
                    <h5 class="fw-bold">Medical Documents</h5>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                    <a href="#" class="read-more text-dark fw-bold text-decoration-none">
                        READ MORE <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <i class="bi bi-stethoscope position-absolute bottom-0 end-0 opacity-10 pe-3 pb-3 fs-1"></i>
                </div>
            </div>

            <!-- CARD 5 (highlighted) -->
            <div class="col-md-4">
                <div class="service-card bg-warning text-white p-4 h-100 text-start rounded position-relative overflow-hidden">
                    <h5 class="fw-bold">Family Documents</h5>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                    <a href="#" class="read-more text-white fw-bold text-decoration-none">
                        READ MORE <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <i class="bi bi-journal-text position-absolute bottom-0 end-0 opacity-25 pe-3 pb-3 fs-1"></i>
                </div>
            </div>

            <!-- CARD 6 -->
            <div class="col-md-4">
                <div class="service-card bg-white text-dark p-4 h-100 text-start rounded position-relative overflow-hidden">
                    <h5 class="fw-bold">Vehicle Documents</h5>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                    <a href="#" class="read-more text-dark fw-bold text-decoration-none">
                        READ MORE <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <i class="bi bi-car-front position-absolute bottom-0 end-0 opacity-10 pe-3 pb-3 fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="notary-cta position-relative text-white text-center d-flex align-items-center justify-content-center"
    style="background-image: url('/img/notary-video.jpg'); background-size: cover; background-position: center; height: 90vh;">

    <!-- Shtresa e errët sipër fotos -->
    <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 0, 0, 0.7);"></div>

    <div class="container position-relative z-1">
        <h2 class="fw-bold display-6 mb-3">Rezervo Takim Për të Noterizuar Dokumentet e Tua</h2>
        <p class="lead mb-4">Proces i shpejtë, i ligjshëm dhe i sigurt për çdo dokument që ke nevojë</p>

        <a href="{{ route('notaries.index') }}" class="btn btn-warning text-white fw-bold px-5 py-2">
            REZERVO TAKIM
        </a>
    </div>
</section>



























<section class="py-5 bg-light" id="notaries">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h2 class="mb-3 mb-md-0">Lista e Noterëve</h2>
            <!-- Filtro sipas qytetit -->
            <form method="GET" action="{{ route('home') }}" class="row g-2">
                <div class="col">
                    <select name="city" class="form-select" onchange="this.form.submit()">
                        <option value="">Zgjedh qytetin</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        @if($notaries->count())
            <div id="notaryCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($notaries->chunk(3) as $index => $notaryChunk)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row">
                                @foreach($notaryChunk as $notary)
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100 shadow-sm border-0">
                                        @php
    $photo = $notary->user->profile_photo;
@endphp

@if($photo && file_exists(public_path('storage/' . $photo)))
    <img src="{{ asset('storage/' . $photo) }}" class="card-img-top" alt="Noteri">
@else
    <img src="https://via.placeholder.com/400x250?text=Noteri" class="card-img-top" alt="Noteri">
@endif

                                            <div class="card-body d-flex flex-column justify-content-between">
                                                <div>
                                                    <h5 class="card-title">{{ $notary->user->name }}</h5>
                                                    <p class="card-text mb-3">
                                                        Qyteti: {{ $notary->city->name }}<br>
                                                        Telefoni: {{ $notary->phone }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('notaries.show', $notary->id) }}" class="btn btn-outline-secondary btn-sm">
                                                        Detaje
                                                    </a>
                                                    <a href="{{ route('bookings.create', ['id' => $notary->id]) }}" class="btn btn-primary btn-sm">
                                                        Rezervo Takim
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#notaryCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Prapa</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#notaryCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Para</span>
                </button>
            </div>
        @else
            <p class="text-muted">Nuk ka noterë për këtë qytet.</p>
        @endif
    </div>
</section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
