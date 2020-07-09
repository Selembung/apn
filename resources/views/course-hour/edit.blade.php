@extends('layouts.app', [
'title' => 'Course Hour',
'activePage' => 'course-hour'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'course-hour'
])

<div class="container-fluid mt--7">

    {{-- Breadcumb --}}
    <div class="row">
        <div class="col mt--6">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('course-hour') }}">Course Hour</a></li>
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
                        <h3 class="mb-0">Form Course Hour</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ url('course-hour/' . $courseHour->id_jam) }}" method="post">
                            @method('patch')
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input
                                                class="timepicker flatpickr-input form-control @error('jam_masuk') is-invalid @enderror bg-secondary pl-3 "
                                                type="text" placeholder="Jam Masuk" name="jam_masuk"
                                                value="{{ $courseHour->jam_masuk }}">
                                        </div>
                                        @error('jam_masuk')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input
                                                class="timepicker flatpickr-input form-control @error('jam_keluar') is-invalid @enderror bg-secondary pl-3"
                                                style="background-color: aqua" type="text" placeholder=" Jam Keluar"
                                                name="jam_keluar" value="{{ $courseHour->jam_keluar }}">
                                        </div>
                                        @error('jam_keluar')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection