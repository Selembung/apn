<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Tahun Akademik</h5>
                                    @if ($academicYear->count() > 0 && $academicYear[0]->status == 'Aktif')
                                    <span class="h3 font-weight-bold mb-0">{{ $academicYear[0]->tahun_akademik }}</span>
                                    @else
                                    <span class="h3 text-info font-weight-bold mb-0"><a href="/academic-year">Aktifkan
                                            Tahun Akademik</a> </span>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                @if ($academicYear->count() > 0 && $academicYear[0]->status == 'Aktif')
                                <span class="text-success mr-2"><i class="fas fa-check-circle"></i> Aktif</span>
                                @else
                                <span class="text-normal mr-2"><i class="fas fa-info-circle"></i> Nonaktif</span>
                                @endif
                                <span class="text-nowrap"></span>
                            </p>
                        </div>
                    </div>
                </div>

                @if (Auth::check() && Auth::user()->role == 'Admin')
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Siswa</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $student->count() }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-info mr-2"><i class="fa fa-clock"></i> Update
                                    Terakhir:</span>
                                <span class="text-nowrap">{{ $dateStudent }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Guru</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $teacher->count() }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-info mr-2"><i class="fa fa-clock"></i> Update Terakhir:</span>
                                <span class="text-nowrap">{{ $dateTeacher }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Jurusan</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $major->count() }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-sitemap"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-normal mr-2"><i class="fa fa-minus"></i></span>
                                <span class="text-nowrap">tidak ada informasi</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endif


                @if (Auth::check() && Auth::user()->role == 'siswa')
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Semester</h5>
                                    <span class="h3 font-weight-bold mb-0">{{ $infoSiswa[0]->semester_aktif }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-info mr-2"><i class="fas fa-tag"></i> Jurusan:</span>
                                <span class="text-nowrap">{{ $infoSiswa[0]->nama_jurusan }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Rombel</h5>
                                    <span class="h3 font-weight-bold mb-0">{{ $infoSiswa[0]->kode_rombel }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning  text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-info mr-2"><i class="fas fa-user"></i> Wali Kelas:</span>
                                @if (!empty($homeroomTeacher->nama))
                                <span class="text-nowrap">{{ $homeroomTeacher->nama }}</span>
                                @endif
                                <span class="text-nowrap">{{__('Belum ada wali kelas') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Nomor Induk Siswa</h5>
                                    <span class="h3 font-weight-bold mb-0">{{ $infoSiswa[0]->nis }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning  text-white rounded-circle shadow">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-info mr-2"><i class="fas fa-envelope"></i> e-mail</span>
                                <span class="text-nowrap">{{ $infoSiswa[0]->email }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endif


                @if (Auth::check() && Auth::user()->role == 'guru')
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Wali Kelas Rombel</h5>
                                    @if ($homeroom->count() > 0)
                                    <span class="h3 font-weight-bold mb-0">{{ $homeroom[0]->kode_rombel }}</span>
                                    @endif
                                    <span class="h3 font-weight-bold mb-0">{{ __('') }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-info mr-2"><i class="fas fa-tag"></i></span>
                                @if ($homeroom->count() > 0)
                                <span class="text-nowrap">{{ $homeroom[0]->nama_rombel }}</span>
                                @endif
                                <span class="text-nowrap">{{ __('') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>