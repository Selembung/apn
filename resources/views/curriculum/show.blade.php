@extends('layouts.app', [
'title' => 'Curriculum',
'activePage' => 'curriculum'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'curriculum'
])

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">

            @include('alerts.alert')

            <div class="card shadow mb-5">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0">Curriculum</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/curriculum/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add curriculum">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-hover px-3 pt-3 pb-3">
                    <table class="table align-items-center table-flush" id="datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode MP</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        @foreach ($data as $item)
                        <tbody class="list">
                            <tr>
                                <td scope="row">{{ $curriculum->kode_mp }}</td>
                                <td scope="row"> {{ $item->nama_mp }}</td>
                                <td scope="row">{{ $curriculum->nama_mp }}</td>
                                <td scope="row">{{ $curriculum->semester }}</td>
                                <td scope="row"></td>
                            </tr>
                        </tbody>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection