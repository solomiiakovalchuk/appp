<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href= "{{ asset('css/css/fontawesome.css') }}">
    <link rel="stylesheet" href= "{{ asset('css/css/templatemo-stand-blog.css') }}">
    <link rel="stylesheet" href= "{{ asset('css/css/owl.css') }}">
  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href= "{{ route(name: 'posts.index') }}"><h2>NewsPortal<em>.</em></h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href= "{{ route(name: 'posts.index') }}">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html">About Us</a>
              </li>
                @auth
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route(name: 'profile.edit') }}">Account</a>
                  </li>
                @endauth
                @auth
                    @if(auth()->user()->canAccessPanel(app(\Filament\Panel::class)))
                        <li class="nav-item">
                            <a class="nav-link" href="/admin">Admin Panel</a>
                        </li>
                    @endif
                @endauth
              <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth
                        <li class="nav-item">
                            <a href="{{ route('locale.switch', 'uk') }}" class="nav-link">Українська</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('locale.switch', 'en') }}" class="nav-link">English</a>
                        </li>
              </ul>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <main>@yield('content')</main>


    <x-footer />

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Additional Scripts -->
    <script src ="{{ asset('js/js/custom.js') }}"></script>
    <script src ="{{ asset('js/js/owl.js') }}"></script>
    <script src ="{{ asset('js/js/slick.js') }}"></script>
    <script src ="{{ asset('js/js/isotope.js') }}"></script>
    <script src ="{{ asset('js/js/accordions.js') }}"></script>

@yield('scripts')

    <script language = "text/Javascript">
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>
    <script>
        window.onload = function() {
            setTimeout(function() {
                document.getElementById('preloader').style.display = 'none';
            }, 3000); // 3 seconds
        };
    </script>
  </body>
</html>
