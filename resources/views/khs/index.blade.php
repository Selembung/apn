@extends('layouts.app', [
'title' => 'Kartu Hasil Studi',
'activePage' => 'khs'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'khs'
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
                            <h3 class="mb-0">Kartu Hasil Studi</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="/print/" class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
                                data-original-title="Cetak KHS">
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
                                <th>No</th>
                                <th>Kode MP</th>
                                <th>Nama Pelajaran</th>
                                <th>SKS</th>
                                <th>Nilai Harian</th>
                                <th>Nilai Praktek</th>
                                <th>Nilai UTS</th>
                                <th>Nilai UAS</th>
                                <th>Nilai Akhir</th>
                                <th>Grade</th>
                                <th>Nilai Sikap</th>
                            </tr>
                        </thead>


                        <tfoot class="table-borderless">
                            <tr>
                                {{-- <th>No</th>
                                <th>Kode MP</th>
                                <th>Nama Pelajaran</th>
                                <th>SKS</th>
                                <th>Nilai</th>
                                <th>Action</th> --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    var table = $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('table.khs') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'kode_mp', name: 'kode_mp', "sClass": "text-center"},    
            {data: 'nama_mp', name: 'nama_mp'},
            {data: 'jumlah_sks', name: 'jumlah_sks', "sClass": "text-center"},
            {data: 'nilai_harian', name: 'nilai_harian', "sClass": "text-center"},
            {data: 'nilai_praktek', name: 'nilai_praktek', "sClass": "text-center"},
            {data: 'nilai_uts', name: 'nilai_uts', "sClass": "text-center"},
            {data: 'nilai_uas', name: 'nilai_uas', "sClass": "text-center"},
            {data: 'nilai_akhir', name: 'nilai_akhir', "sClass": "text-center"},
            {data: 'grade', name: 'grade', "sClass": "text-center"},
            {data: 'nilai_sikap', name: 'nilai_sikap', "sClass": "text-center"},
        ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
        } 
    });

    // $('#filter_jurusan').change(function () {
    //     table.column($(this).data('column'))
    //         .search($(this).val())
    //         .draw();
    // });

    // $('#reset').click(function () {
    //     table.column($(this).data(''))
    //         .search($(this).val())
    //         .draw();
    //         $("#filter_jurusan")[0].selectedIndex = 0
    // });

</script>

@endpush