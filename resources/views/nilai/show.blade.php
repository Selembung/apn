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
                            <table>
                                <tr>
                                    <th>
                                        <h5 class="font-weight-normal">NIS</h5>
                                    </th>
                                    <th class="pl-2">
                                        <h5>:</h5>
                                    </th>
                                    <td class="pl-2">
                                        <h5>{{ $siswa[0]->nis }}</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h5 class="font-weight-normal">Nama</h5>
                                    </th>
                                    <th class="pl-2">
                                        <h5>:</h5>
                                    </th>
                                    <td class="pl-2">
                                        <h5>{{ $siswa[0]->nama_siswa }}</h5>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ url('cetak-rapor/' . $siswa[0]->nis) }}"
                                class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
                                data-original-title="Cetak nilai">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Cetak</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-hover px-3 pt-3 pb-3">
                    <table class="table align-items-center table-flush" id="datatable">
                        {{-- <h5 class="font-weight-normal">NIS</h5>
                        <h5 class="font-weight-normal">Nama</h5> --}}
                        <thead class="thead-light">
                            <tr>
                                <th>Nama Mata Pelajaran</th>
                                <th class="text-center">Pengetahuan</th>
                                <th class="text-center">Keterampilan</th>
                                <th class="text-center">Spritual</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($siswa as $s)
                            <tr>
                                <th>{{ $s->nama_mp }}</th>
                                <th class="text-center">{{ $s->nilai_akhir }}</th>
                                <th class="text-center">{{ $s->nilai_praktek }}</th>
                                <th class="text-center">{{ $s->nilai_sikap }}</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection