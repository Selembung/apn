@extends('layouts.app', [
'title' => 'Nilai',
'activePage' => 'nilai'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'nilai'
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
                            <h3 class="mb-0">Nilai</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/cetak" class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
                                data-original-title="Cetak Leger Nilai">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Cetak</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-hover px-3 pt-3 pb-3">
                    <table class="table align-items-center table-flush" id="datatable">

                        <thead class="thead-light">
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                {{-- <th class="text-center">Pengetahuan</th>
                                <th class="text-center">Keterampilan</th>
                                <th class="text-center">Spritual</th> --}}
                                {{-- <th>Mata Pelajaran</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($siswa as $s)
                            <tr>
                                {{-- <th>{{ dd($s) }}</th> --}}
                                <th>{{ $s->nis }}</th>
                                <th>{{ $s->nama_siswa }}</th>
                                {{-- <th class="text-center">{{ $s->nilai_akhir }}</th>
                                <th class="text-center">{{ $s->nilai_praktek }}</th>
                                <th class="text-center">{{ $s->nilai_sikap }}</th> --}}
                                {{-- <th>{{ $s->nama_mp }}</th> --}}
                                <th>
                                    {{-- @if () --}}
                                    <a href="{{ url('score-homeroom/' . $s->nis) }}"
                                        class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
                                        data-original-title="Detail Nilai Siswa">
                                        <span class="btn-inner--icon"><i class="fas fa-archive"></i></span>
                                        {{-- <span class="btn-inner--text"></span> --}}
                                    </a>
                                    {{-- @endif --}}
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                {{-- <th class="text-center">Pengetahuan</th>
                                <th class="text-center">Keterampilan</th>
                                <th class="text-center">Spritual</th> --}}
                                {{-- <th>Mata Pelajaran</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection