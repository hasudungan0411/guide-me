<header class="header-area header-three">
    <div class="header-navigation">
        <div class="nav-overlay"></div>
        <div class="container-fluid">
            <div class="primary-menu gray-bg">
                <div class="site-brading d-block d-xl-none">
                    <a style="width: 120px; height: 50px" href="" class="brand-logo mb-3">
                        <img src="{{ asset('assets/wisatawan/images/logo/logo-black.png') }}" alt="Logo">
                    </a>
                </div>

                <div class="nav-menu">
                    <div class="mobile-logo mb-30 d-block d-xl-none">
                        <a style="width: 120px; height: 50px" href="" class="brand-logo">
                            <img src="{{ asset('assets/wisatawan/images/logo/logo-black.png') }}" alt="Site Logo">
                        </a>
                    </div>

                    <nav class="main-menu">
                        <ul>
                            <li>
                                <a class="d-none d-xl-block" style="width: 120px;" href="">
                                    <img src="{{ asset('assets/wisatawan/images/logo/logo-black.png') }}" alt="Site Logo">
                                </a>
                            </li>
                            <li class="menu-item has-children {{ request()->is('/') ? 'active' : '' }}">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="menu-item has-children {{ request()->is('tour*') ? 'active' : '' }}">
                                <a href="{{ url('/tour') }}">Destinasi</a>
                            </li>
                            <li class="menu-item has-children {{ request()->is('blog*') ? 'active' : '' }}">
                                <a href="{{ url('/blog-list') }}">Blog</a>
                            </li>
                            <li class="menu-item has-children {{ request()->is('gallery') ? 'active' : '' }}">
                                <a href="{{ url('/gallery') }}">Galeri</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="nav-right-item">
                    @php
                        $excludedPages = ['gallery', 'tour', 'blog-list', 'blog_category', 'tour_details', 'blog-details'];
                    @endphp
                    @if (!in_array(request()->path(), $excludedPages))
                        <div style="z-index: 9999;" class="menu-button d-xl-block d-none">
                            <a href="#start" class="main-btn primary-btn">Jelajah <i class="fas fa-paper-plane"></i></a>
                        </div>
                    @endif
                    <div class="navbar-toggler">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
