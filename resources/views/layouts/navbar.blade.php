
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="#">
            <img src="{{ url('image/Logo_usu_mini.png') }}" class="mr-2" alt="logo" style="width: 40px; height: 40px;" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="#">
            <img src="{{ url('image/logo_usu_mini.png') }}" alt="logo" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <i class="fa-solid fa-bars fa-fw"></i>
        </button>
        <h5 id="tanggal" style="font-family: 'Bebas Neue', sans-serif; color: green; text-outlined;
        font-weight: bold; text-align: center; margin: 1.2rem 1rem"></h5>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
                <a class="nav-link d-none d-lg-block" href="#" style="font-family: 'Bebas Neue', sans-serif; color: green; text-outlined;
                font-weight: bold; text-align: center; margin: 1rem auto"> 
                    @if(Auth::user()->role == '1')
                    Administrator
                    @elseif(Auth::user()->role == '2')
                    PIC Universitas
                    @endif - {{ Auth::user()->nama_operator }}
                </a>
            </li>
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{ Avatar::create(Auth::user()->nama_pengguna)->toBase64() }}" alt="profile" />
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ url('/logout') }}">
                        <i class="fa-solid fa-right-from-bracket fa-fw mr-2"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <i class="fa-solid fa-bars fa-fw"></i>
        </button>
    </div>
</nav>
