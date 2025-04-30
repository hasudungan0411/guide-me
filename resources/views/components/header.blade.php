<header class="header-area header-three">
    <div class="header-navigation">
        <div class="nav-overlay"></div>
        <div class="container-fluid">
            <div class="primary-menu gray-bg">

                {{-- Logo (mobile & desktop) --}}
                <div class="site-brading d-block d-xl-none"
                    style="display: flex; justify-content: center; align-items: center; height: 50px;">
                    <a style="width: 110px; height: 50px;">
                        <img src="{{ asset('assets/wisatawan/images/logo/logo-black.png') }}" alt="Logo">
                    </a>
                </div>

                <div class="nav-menu">
                    <nav class="main-menu">
                        <ul class="d-flex flex-column flex-xl-row align-items-xl-center">
                            <li class="me-0">
                                <a class="d-none d-xl-block" style="width: 120px;" href="">
                                    <img src="{{ asset('assets/wisatawan/images/logo/logo-black.png') }}"
                                        alt="Site Logo">
                                </a>
                            </li>
                            <li
                                class="me-0 menu-item has-children {{ Request::is('wisatawan/home*') ? 'active' : '' }}">
                                <a href="{{ url('/wisatawan/home') }}"
                                    class="btn btn-outline-info d-flex align-items-center px-2 py-3 border-0">
                                    Beranda</a>
                            </li>
                            <li
                                class="me-0 menu-item has-children {{ Request::is('wisatawan/destinasi*') ? 'active' : '' }}">
                                <a href="{{ url('/wisatawan/destinasi') }}"
                                    class="btn btn-outline-info d-flex align-items-center px-2 py-3 border-0">Destinasi</a>
                            </li>
                            <li class="me-0 menu-item has-children">
                                <a href="{{ url('/wisatawan/blog') }}"
                                    class="btn d-flex align-items-center px-2 py-3 border-0
                                        {{ Request::is('wisatawan/blog*') ? 'bg-info text-white border border-info' : 'btn-outline-info text-dark' }}">
                                    Blog
                                </a>
                            </li>
                            <li
                                class="me-0 menu-item has-children {{ Request::is('wisatawan/galeri') ? 'active' : '' }}">
                                <a href="{{ url('/wisatawan/galeri') }}"
                                    class="btn btn-outline-info d-flex align-items-center px-2 py-3 border-0">Galeri</a>
                            </li>
                            <li
                                class="me-0 menu-item has-children {{ Request::is('wisatawan/acara') ? 'active' : '' }}">
                                <a href="{{ url('/wisatawan/acara') }}"
                                    class="btn btn-outline-info d-flex align-items-center px-2 py-3 border-0">Acara</a>
                            </li>
                            <li
                                class="me-0 menu-item has-children {{ Request::is('wisatawan/galeri') ? 'active' : '' }}">
                                <a href="{{ url('/wisatawan/galeri') }}"
                                    class="btn btn-outline-info d-flex align-items-center px-2 py-3 border-0">Saran
                                    Destinasi</a>
                            </li>
                            <li class="me-0 menu-item has-children">
                                <a class="nav-link py-1 btn d-flex align-items-center px-2 py-3 border-0
                                    {{ Request::is('wisatawan/kategori*') ? 'bg-info text-white border border-info' : 'btn-outline-info text-dark' }}"
                                    href="#" id="kategoriDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Kategori
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="kategoriDropdown">
                                    <li><a class="dropdown-item px-1 py-2" href="{{route('wisatawan.kategori-destinasi')}}">Destinasi</a></li>
                                    <li><a class="dropdown-item px-1 py-2" href="{{route('wisatawan.kategori-blog')}}">Blog</a></li>
                                </ul>
                            </li>
                            <li
                                class="menu-item has-children {{ Request::is('wisatawan/chatbot') ? 'active' : '' }} d-block d-xl-none">
                                <a href="{{ route('wisatawan.chatbot') }}"
                                    class="btn btn-outline-success d-flex align-items-center px-2 py-3 border-0">
                                    Teman Wisata <i class="fas fa-comments"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="nav-right-item d-flex align-items-center">
                    {{-- Dropdown Bahasa untuk mobile --}}
                    <div class="dropdown d-block d-xl-none">
                        <button
                            class="btn btn-outline-success dropdown-toggle d-flex align-items-center justify-content-center"
                            style="height: 40px; width: 50px;" type="button" id="languageDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe me-2"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="?lang=id">Indonesia</a></li>
                            <li><a class="dropdown-item" href="?lang=en">English</a></li>
                        </ul>
                    </div>

                    {{-- Dropdown Bahasa untuk desktop --}}
                    <div class="dropdown me-2 d-none d-xl-block">
                        <button class="btn btn-outline-success dropdown-toggle d-flex align-items-center px-2 py-2"
                            type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe me-2"></i> Bahasa
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="?lang=id">Indonesia</a></li>
                            <li><a class="dropdown-item" href="?lang=en">English</a></li>
                        </ul>
                    </div>

                    {{-- Icon Login desktop --}}
                    <div class="menu-button d-none d-xl-block ms-2">
                        <a href="{{ route('login') }}"
                            class="btn btn-outline-primary d-flex align-items-center px-2 py-2">
                            <i class="fas fa-sign-in-alt me-2"></i> Masuk
                        </a>
                    </div>

                    {{-- Icon Login mobile --}}
                    <div class="menu-button d-block d-xl-none ms-2">
                        <a href="{{ route('login') }}"
                            class="btn btn-outline-primary d-flex align-items-center justify-content-center"
                            style="height: 40px; width: 50px;">
                            <i class="fas fa-user-circle"></i>
                        </a>
                    </div>

                    {{-- Tombol Teman Wisata desktop --}}
                    <div class="menu-button d-none d-xl-block ms-3" style="z-index: 9999;">
                        <a href="{{ route('wisatawan.chatbot') }}" class="main-btn primary-btn px-3 py-2 text-right">
                            Teman Wisata <i class="fas fa-comments ms-1"></i>
                        </a>
                    </div>

                    {{-- Tombol favorite desktop --}}
                    <div class="menu-button d-none d-xl-block ms-4">
                        <a href="#"
                            class="btn d-flex align-items-center px-3 py-3 border-3
                        {{ Request::is('wisatawan/galeri*') ? 'bg-info text-white border border-info' : 'btn-outline-info text-dark' }}">
                            <i class="far fa-bookmark"></i>
                        </a>
                    </div>

                    {{-- tobol Favorite mobile --}}
                    <div class="menu-button d-block d-xl-none ms-2">
                        <a href="#"
                            class="btn btn-outline-info d-flex align-items-center justify-content-center"
                            style="height: 40px; width: 50px;">
                            <i class="far fa-bookmark"></i>
                        </a>
                    </div>

                    {{-- Hamburger Menu --}}
                    <div class="navbar-toggler ms-3" style="height: 20%; width: 25%;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
</header>
