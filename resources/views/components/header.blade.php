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
                        <ul class="d-flex flex-column flex-xl-row align-items-xl-center ">
                            <li class="me-0">
                                <a class="d-none d-xl-block" style="width: 120px;" href="">
                                    <img src="{{ asset('assets/wisatawan/images/logo/logo-black.png') }}"
                                        alt="Site Logo">
                                </a>
                            </li>
                            <li
                                class="me-0 menu-item has-children">
                                <a href="{{ url('/wisatawan/home') }}"
                                    class="btn btn-outline-info d-flex align-items-center px-2 py-3 border-0 {{ Request::is('wisatawan/home') ? 'bg-info text-white border border-info' : 'btn-outline-info text-dark' }}">Beranda</a>
                            </li>
                            <li
                                class="me-0 menu-item has-children">
                                <a href="{{ url('/wisatawan/destinasi') }}"
                                    class="btn btn-outline-info d-flex align-items-center px-2 py-3 border-0 {{ Request::is('wisatawan/destinasi*') ? 'bg-info text-white border border-info' : 'btn-outline-info text-dark' }}">Destinasi</a>
                            </li>
                            <li class="me-0 menu-item has-children">
                                <a href="{{ url('/wisatawan/blog') }}"
                                    class="btn d-flex align-items-center px-2 py-3 border-0 {{ Request::is('wisatawan/blog*') ? 'bg-info text-white border border-info' : 'btn-outline-info text-dark' }}">Blog</a>
                            </li>
                            <li
                                class="me-0 menu-item has-children">
                                <a href="{{ url('/wisatawan/galeri') }}"
                                    class="btn btn-outline-info d-flex align-items-center px-2 py-3 border-0 {{ Request::is('wisatawan/galeri') ?'bg-info text-white border border-info' : 'btn-outline-info text-dark' }}">Galeri</a>
                            </li>
                            <li
                                class="me-0 menu-item has-children">
                                <a href="{{ url('/wisatawan/acara') }}"
                                    class="btn btn-outline-info d-flex align-items-center px-2 py-3 border-0 {{ Request::is('wisatawan/acara*') ? 'bg-info text-white border border-info' : 'btn-outline-info text-dark' }}">Acara</a>
                            </li>
                            <li
                                class="menu-item has-children {{ Request::is('wisatawan/chatbot') ? 'active' : '' }} d-block d-xl-none">
                                <a href="{{ route('wisatawan.chatbot') }}"
                                    class="btn btn-outline-success d-flex align-items-center px-2 py-3 border-0">Teman
                                    Wisata</a>
                            </li>
                            <li class="me-0 menu-item">
                                <a href="{{ route('wisatawan.kategori-destinasi') }}"
                                    class="nav-link py-1 btn d-flex align-items-center px-2 py-3 border-0
                                    {{ Request::is('wisatawan/kategori*') ? 'bg-info text-white border border-info' : 'btn-outline-info text-dark' }}">
                                    Kategori
                                </a>
                            </li>
                            <li class="me-0 menu-item has-children d-block d-xl-none">
                                @auth('wisatawan')
                                    @php
                                        $user = auth('wisatawan')->user();
                                        $nama = $user->Nama ?? 'Wisatawan';
                                        $foto =
                                            $user->Foto_Profil ?? asset('assets/images/avatars/profile-image-2.png');
                                    @endphp

                                    <button type="button"
                                        class="btn btn-outline-dark dropdown-toggle px-2 py-2 d-flex align-items-center"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ $foto }}" alt="Foto Profil"
                                            style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; margin-right: 6px;">
                                        {{-- {{ Str::limit($nama, 10) }} --}}
                                    </button>

                                    <ul class="dropdown-menu mt-2">
                                        <li><a class="dropdown-item" href="{{ route('wisatawan.favorit') }}">Favorit</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('wisatawan.logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">Keluar</button>
                                            </form>
                                        </li>
                                    </ul>
                                @else
                                    <a href="{{ route('wisatawan.login') }}" class="btn btn-warning px-3 py-2">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                    </a>
                                @endauth
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="nav-right-item d-flex align-items-center">
                    {{-- Search Bar desktop --}}
                    <div class="search-container d-none d-xl-block me-3 position-relative" style="width: 300px;">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Cari destinasi, blog, atau kategori..."
                            style="padding-left: 40px; height: 48px; border-radius: 20px; border: 1px solid #ccc;">

                        <span class="position-absolute"
                            style="left: 12px; top: 50%; transform: translateY(-50%); color: #57ef0c;">
                            <i class="fas fa-search"></i>
                        </span>
                        <div id="searchResults" class="dropdown-menu show d-none mt-1"
                            style="position: absolute; width: 100%; max-height: 300px; overflow-y: auto; border-radius: 10px;">
                        </div>
                    </div>

                    {{-- Search Mobile --}}
                    <div class="d-block d-xl-none position-relative">
                        <!-- Tombol Search Bulat -->
                        <button id="mobileSearchToggle" class="btn btn-outline-success"
                            style="border-radius: 50%; padding: 6px 10px;">
                            <i class="fas fa-search"></i>
                        </button>
                        <!-- Kotak Input Search -->
                        <div id="mobileSearchBox" class="position-absolute top-50 translate-middle-y end-100 d-none"
                            style="width: 200px; z-index: 1050; margin-right: 8px;">
                            <div class="position-relative">
                                <input type="text" id="mobileSearchInput" class="form-control"
                                    placeholder="Cari destinasi, blog, kategori..."
                                    style="padding-left: 35px; height: 42px; border-radius: 20px; border: 1px solid #ccc; font-size: 14px;">
                                <!-- Icon pencarian di dalam input -->
                                <span class="position-absolute"
                                    style="left: 12px; top: 50%; transform: translateY(-50%); color: #57ef0c;">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <!-- Dropdown hasil pencarian -->
                            <div id="mobileSearchResults" class="dropdown-menu show d-none mt-1"
                                style="max-height: 200px; overflow-y: auto; border-radius: 10px; width: 100%;"></div>
                        </div>
                    </div>

                    {{-- Tombol Teman Wisata desktopp --}}
                    <div class="menu-button d-none d-xl-block">
                        <a href="{{ route('wisatawan.chatbot') }}" class="main-btn primary-btn px-3 py-2 text-right">
                            Teman Wisata <i class="fas fa-comments ms-1"></i>
                        </a>
                    </div>

                    <!-- Login Wisatawan -->
                    <div class="btn-group d-none d-xl-inline ms-3">
                        @auth('wisatawan')
                            @php
                                $user = auth('wisatawan')->user();
                                $nama = $user->Nama ?? 'Wisatawan';
                                $foto = $user->Foto_Profil ?? asset('assets/images/avatars/profile-image-2.png');
                            @endphp

                            <button type="button"
                                class="btn btn-outline-dark dropdown-toggle px-2 py-2 d-flex align-items-center"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ $foto }}" alt="Foto Profil"
                                    style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; margin-right: 6px;">
                                {{-- {{ Str::limit($nama, 10) }} --}}
                            </button>

                            <ul class="dropdown-menu mt-2">
                                <li><a class="dropdown-item" href="{{ route('wisatawan.favorit') }}">Favorit</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('wisatawan.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <a href="{{ route('wisatawan.login') }}" class="btn btn-warning px-3 py-2">
                                <i class="fas fa-sign-in-alt me-1"></i>
                            </a>
                        @endauth
                    </div>

                    {{-- Hamburger Menu --}}
                    <div class="navbar-toggler">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        const mobileToggle = document.getElementById('mobileSearchToggle');
        const mobileBox = document.getElementById('mobileSearchBox');
        const mobileInput = document.getElementById('mobileSearchInput');
        const mobileResults = document.getElementById('mobileSearchResults');

        // Fungsi ambil data
        function fetchSearchResults(query = '', targetBox) {
            fetch(`/wisatawan/search?q=${query}`)
                .then(res => res.json())
                .then(data => {
                    targetBox.innerHTML = data.length === 0 ?
                        '<span class="dropdown-item disabled">Tidak ditemukan</span>' :
                        data.map(item => {
                            const href =
                                item.tipe === 'destinasi' ?
                                `/wisatawan/destinasi/detail_destinasi/${item.id}` :
                                item.tipe === 'blog' ? `/wisatawan/blog/${item.slug}` :
                                item.tipe === 'kategori' ?
                                `/wisatawan/kategori/destinasi/${item.id_kategori}` : '#';

                            return `<a href="${href}" class="dropdown-item">${item.nama}</a>`;
                        }).join('');
                    targetBox.classList.remove('d-none');
                })
                .catch(() => {
                    targetBox.innerHTML = '<span class="dropdown-item disabled">Terjadi kesalahan.</span>';
                    targetBox.classList.remove('d-none');
                });
        }

        // Desktop events
        if (searchInput && searchResults) {
            searchInput.addEventListener('focus', () => fetchSearchResults('', searchResults));
            searchInput.addEventListener('input', () =>
                fetchSearchResults(searchInput.value.trim(), searchResults)
            );
        }

        // Mobile toggle & input
        if (mobileToggle && mobileBox && mobileInput && mobileResults) {
            mobileToggle.addEventListener('click', () => {
                // Menambahkan animasi rotasi
                mobileToggle.querySelector('i').classList.toggle('rotate-icon');
                mobileBox.classList.remove('d-none');
                mobileToggle.classList.add('d-none');
                mobileInput.focus();
            });

            mobileInput.addEventListener('input', () =>
                fetchSearchResults(mobileInput.value.trim(), mobileResults)
            );
        }

        // Klik luar
        document.addEventListener('click', function(e) {
            if (!searchInput?.contains(e.target) && !searchResults?.contains(e.target)) {
                searchResults?.classList.add('d-none');
            }
            if (!mobileBox?.contains(e.target) && !mobileToggle?.contains(e.target)) {
                mobileBox?.classList.add('d-none');
                mobileToggle?.classList.remove('d-none');
                // Menghapus animasi rotasi saat icon kembali
                mobileToggle.querySelector('i').classList.remove('rotate-icon');
            }
        });
    });
</script>
