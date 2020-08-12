<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            {{-- <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="..."> --}}
            <h2 class="text-primary">App Nilai</h2>
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended"
                        placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            @if (Auth::check())
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link  @if ($activePage == 'dashboard') active text-primary @endif"
                        href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button"
                        aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fab fa-laravel" style="color: #f4645f;"></i>
                        <span class="nav-link-text" style="color: #f4645f;">{{ __('Laravel Examples') }}</span>
                </a>

                <div class="collapse show" id="navbar-examples">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link @if ($activePage == 'user-profile') active  @endif"
                                href="{{ route('profile.edit') }}">
                                {{ __('User profile') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($activePage == 'user-management') active  @endif"
                                href="{{ route('user.index') }}">
                                {{ __('User Management') }}
                            </a>
                        </li>
                    </ul>
                </div>
                </li> --}}
            </ul>
            @endif

            {{-- @if (Auth::check() && Auth::user()->role == 'Admin' || Auth::user()->role == 'siswa') --}}
            @if (Auth::check() && Auth::user()->role == 'siswa')
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Students</h6>
            <ul class="navbar-nav mb-md-3">
                {{-- <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'schedule') active text-warning @endif" href="/schedule">
                        <i class="ni ni-circle-08 text-warning"></i> {{ __('Course Schedule') }}
                </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'khs') active text-primary @endif" href="/khs">
                        <i class="ni ni-satisfied text-primary"></i> {{ __('KHS') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if ($activePage == 'krs') active text-green @endif" href="/krs">
                        <i class="ni ni-archive-2 text-green"></i> {{ __('KRS') }}
                    </a>
                </li>
            </ul>
            @endif

            {{-- @if (Auth::check() && Auth::user()->role == 'Admin' || Auth::user()->role == 'guru') --}}
            @if (Auth::check() && Auth::user()->role == 'guru')
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Teachers</h6>
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item ">
                    <a class="nav-link @if ($activePage == 'teachingSchedule') active text-primary @endif"
                        href="/teaching-schedule">
                        <i class="ni ni-archive-2 text-primary"></i> {{ __('Jadwal Mengajar') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if ($activePage == 'nilai') active text-info @endif" href="/score-homeroom">
                        <i class="ni ni-archive-2 text-info"></i> {{ __('Nilai Siswa Wali') }}
                    </a>
                </li>
            </ul>
            @endif

            @if (Auth::check() && Auth::user()->role == 'Admin')
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Data Master</h6>
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item ">
                    <a class="nav-link @if ($activePage == 'student') active text-primary @endif" href="/student">
                        <i class="ni ni-archive-2 text-primary"></i> {{ __('Siswa') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'teacher') active text-info @endif" href="/teacher">
                        <i class="ni ni-circle-08 text-info"></i> {{ __('Guru') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if ($activePage == 'course') active text-pink @endif" href="/course">
                        <i class="ni ni-archive-2 text-pink"></i> {{ __('Mata Pelajaran') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'academic-year') active text-warning @endif"
                        href="/academic-year">
                        <i class="ni ni-circle-08 text-warning"></i> {{ __('Tahun Akademik') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'major') active text-green @endif" href="/major">
                        <i class="ni ni-books text-green"></i> {{ __('Jurusan') }}
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'curriculum') active text-yellow @endif" href="/curriculum">
                        <i class="ni ni-collection text-yellow"></i> {{ __('Curriculum') }}
                </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'course-hour') active text-info @endif" href="/course-hour">
                        <i class="ni ni-watch-time text-info"></i> {{ __('Jam Mata Pelajaran') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'room') active text-warning @endif" href="/room">
                        <i class="ni ni-building text-warning"></i> {{ __('Ruangan') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'course-schedule') active text-danger @endif"
                        href="/course-schedule">
                        <i class="ni ni-calendar-grid-58 text-danger"></i> {{ __('Jadwal Mata Pelajaran') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'rombel') active text-primary @endif" href="/rombel">
                        <i class="ni ni-collection text-primary"></i> {{ __('Rombel') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'homeroom-teacher') active text-info @endif"
                        href="/homeroom-teacher">
                        <i class="ni ni-single-02 text-info"></i> {{ __('Wali Kelas') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($activePage == 'logActivity') active text-green @endif"
                        href="/log-activity">
                        <i class="ni ni-bullet-list-67 text-green"></i> {{ __('Log Aktivitas') }}
                    </a>
                </li>
            </ul>
            @endif

            <!-- Divider -->
            {{-- <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Documentation</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="https://www.creative-tim.com/product/argon-dashboard-pro-laravel"
                        target="_blank">
                        <i class="ni ni-cloud-download-95"></i> Upgrade to PRO
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
                        <i class="ni ni-spaceship"></i> Getting started
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html">
                        <i class="ni ni-palette"></i> Foundation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html">
                        <i class="ni ni-ui-04"></i> Components
                    </a>
                </li>
            </ul> --}}
        </div>
    </div>
</nav>