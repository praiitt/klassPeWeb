<!-- ======= Header ======= -->
<header id="header" class="header fixed-top container-fluid">
    <div class="d-flex align-items-center justify-content-between">
        <span class="menu" id="opennav" onclick="openNav()">
            <img src="" class="menu-scroll" width="50px" height="auto" /></span>

        <a href="{{ url('/') }}" class="logo d-flex align-items-center container-xl">
            <img src="" class="img-scroll">
            <span>KlassPe</span>
        </a>

        <nav id="navbar" class="navbar mr-5">
            <ul class="pr-5">
                @if(session()->get('web_username'))
                <li><a class="nav-link" href="{{ url('Search_tutor') }}"><i class="bi bi-search"></i></a></li>
                <li><a class="nav-link" href="{{ url('Notification') }}"><i class="bi bi-bell-fill"></i></a></li>
                @else
                <li><a class="nav-link" data-toggle="modal" data-target="#loginModal" data-whatever="">Login</a></li>
                <li><a class="nav-link" data-toggle="modal" data-target="#signUpModal" data-whatever="">Register</a></li>
                @endif
            </ul>
            <i class="mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->