@extends('layouts.app', [
'title' => 'Edit Academic Year',
'activePage' => 'academic-year'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'academic-year'
])

<div class="container-fluid mt--7">

    {{-- Breadcumb --}}
    <div class="row">
        <div class="col mt--6">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('academic-year') }}">Academic Year</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form Edit</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- End Breadcumb --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card-wrapper">
                <!-- Form controls -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Form Teacher</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('academic-year/' . $academicYear->kode_tahun_akademik) }}" method="post">
                            @method('patch')
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kode_tahun_akademik">Kode Tahun
                                            Akademik</label>
                                        <input type="text"
                                            class="form-control @error('kode_tahun_akademik') is-invalid @enderror"
                                            id="kode_tahun_akademik" name="kode_tahun_akademik"
                                            value="{{ $academicYear->kode_tahun_akademik }}">
                                        @error('kode_tahun_akademik')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-control-label" for="tahun_akademik">Tahun Akademik</label>
                                        <input type="text"
                                            class="form-control @error('tahun_akademik') is-invalid @enderror"
                                            id="tahun_akademik" name="tahun_akademik"
                                            value="{{ $academicYear->tahun_akademik }}">
                                        @error('tahun_akademik')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="status">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option>Nonaktif</option>
                                            <option @if ($academicYear->status === 'Aktif') selected
                                                @endif>Aktif</option>
                                        </select>
                                        @error('status')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 rounded" style="background-color: #F5F7F9">
                                <div class="form-group ">
                                    <label class="form-control-label mt-2 mb-3" for="tahun_akademik">Periode
                                        Sekolah</label>
                                    <div class="input-daterange datepicker row align-items-center">
                                        <div class="col">
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="ni ni-calendar-grid-58"></i></span>
                                                    </div>
                                                    <input class="form-control" placeholder="Start date" type="text"
                                                        name="tanggal_awal_sekolah"
                                                        value="{{ $academicYear->tanggal_awal_sekolah }}">
                            @error('status')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                    </div>
                </div>
            </div>
            <p>sampai</p>
            <div class="col">
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="form-control" placeholder="End date" type="text" name="tanggal_akhir_sekolah"
                            value="{{ $academicYear->tanggal_akhir_sekolah }}">
                        @error('status')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 rounded" style="background-color: #F5F7F9">
    <div class="form-group ">
        <label class="form-control-label mt-2 mb-3" for="tahun_akademik">Periode
            UTS</label>
        <div class="input-daterange datepicker row align-items-center">
            <div class="col">
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="form-control" placeholder="Start date" type="text" name="tanggal_awal_uts"
                            value="{{ $academicYear->tanggal_awal_uts }}">
                        @error('status')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <p>sampai</p>
            <div class="col">
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="form-control" placeholder="End date" type="text" name="tanggal_akhir_uts"
                            value="{{ $academicYear->tanggal_akhir_uts }}">
                        @error('status')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 rounded" style="background-color: #F5F7F9">
    <div class="form-group ">
        <label class="form-control-label mt-2 mb-3" for="tahun_akademik">Periode
            UAS</label>
        <div class="input-daterange datepicker row align-items-center">
            <div class="col">
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="form-control" placeholder="Start date" type="text" name="tanggal_awal_uas"
                            value="{{ $academicYear->tanggal_awal_uas }}">
                        @error('status')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <p>sampai</p>
            <div class="col">
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="form-control" placeholder="End date" type="text" name="tanggal_akhir_uas"
                            value="{{ $academicYear->tanggal_akhir_uas }}">
                        @error('status')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<button class="btn btn-primary" type="submit">Submit</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection