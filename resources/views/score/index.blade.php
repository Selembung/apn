@extends('layouts.app', [
'title' => 'Score',
'activePage' => 'score'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'score'
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
                            <h3 class="mb-0">Score</h3>
                        </div>
                        {{-- <div class="col-6 text-right">
                            <a href="/score/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add Score">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Add</span>
                            </a>
                        </div> --}}
                    </div>
                </div>
                <div class="table-responsive table-hover px-3 pt-3 pb-3">
                    <table class="table align-items-center table-flush mb-5" id="datatable">
                        <tr>
                            <td class="font-weight-bold">Kode Mata Pelajaran</td>
                            <td>{{ $schedule->kode_mp }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Nama Mata Pelajaran</td>
                            <td>{{ $schedule->nama_mp }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Nama Guru</td>
                            <td>{{ $schedule->nama }}</<td>
                        </tr>
                    </table>
                    <table class="table align-items-center table-flush" id="datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Nilai Harian</th>
                                <th>Nilai Praktek</th>
                                <th>UTS</th>
                                <th>UAS</th>
                                <th>Nilai Akhir</th>
                                <th>Grade</th>
                                <th>Sikap</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($siswa as $s)
                            <tr>
                                <th>{{ $s->nis }}</th>
                                <th>{{ $s->nama }}</th>
                                <th><input id="harian-{{ $s->id }}" type="number" class="form-control text-center"
                                        onchange="simpan_nilai('{{$s->id}}')" value="{{ $s->nilai_harian }}" min="0"
                                        max="100" style="width:auto"></th>
                                <th><input id="praktek-{{ $s->id }}" type="number" class="form-control text-center"
                                        onchange="simpan_nilai('{{$s->id}}')" value="{{ $s->nilai_praktek }}" min="0"
                                        max="100" style="width:auto"></th>
                                <th><input id="uts-{{ $s->id }}" type="number" class="form-control text-center"
                                        onchange="simpan_nilai('{{$s->id}}')" value="{{ $s->nilai_uts }}" min="0"
                                        max="100" style="width:auto"></th>
                                <th><input id="uas-{{ $s->id }}" type="number" class="form-control text-center"
                                        onchange="simpan_nilai('{{$s->id}}')" value="{{ $s->nilai_uas }}" min="0"
                                        max="100" style="width:auto"></th>
                                <th><input id="akhir-{{ $s->id }}" type="number" class="form-control text-center"
                                        onchange="simpan_nilai('{{$s->id}}')" value="{{ $s->nilai_akhir }}" min="0"
                                        max="100" style="width:auto"></th>
                                <th>
                                    <select class="form-control" onchange="simpan_nilai('{{$s->id}}')"
                                        id="grade-{{ $s->id }}" name="grade" style="width:auto;">
                                        <option disabled selected>Pilih</option>
                                        <option value="A" {{ $s->grade == "A" ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ $s->grade == "B" ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ $s->grade == "C" ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ $s->grade == "D" ? 'selected' : '' }}>D</option>
                                        <option value="E" {{ $s->grade == "E" ? 'selected' : '' }}>E</option>
                                    </select>
                                </th>
                                <th>
                                    <select class="form-control" onchange="simpan_nilai('{{$s->id}}')"
                                        id="sikap-{{ $s->id }}" name="nilai_sikap" style="width:auto;">
                                        <option disabled selected>Pilih</option>
                                        <option value="A" {{ $s->nilai_sikap == "A" ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ $s->nilai_sikap == "B" ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ $s->nilai_sikap == "D" ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ $s->nilai_sikap == "D" ? 'selected' : '' }}>D</option>
                                        <option value="E" {{ $s->nilai_sikap == "E" ? 'selected' : '' }}>E</option>
                                    </select>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Nilai Harian</th>
                                <th>Nilai Praktek</th>
                                <th>UTS</th>
                                <th>UAS</th>
                                <th>Nilai Akhir</th>
                                <th>Grade</th>
                                <th>Sikap</th>
                                {{-- <th>Action</th> --}}
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
    function simpan_nilai(id_khs) {

    var nilai_harian = $("#harian-" + id_khs).val();
    var nilai_praktek = $("#praktek-" + id_khs).val();
    var nilai_uts = $("#uts-" + id_khs).val();
    var nilai_uas = $("#uas-" + id_khs).val();
    var nilai_akhir = $("#akhir-" + id_khs).val();
    var grade = $("#grade-" + id_khs).val();
    var nilai_sikap = $("#sikap-" + id_khs).val();

    // console.log(nilai_harian);
    // console.log(nilai_praktek);
    // console.log(nilai_uts);
    // console.log(nilai_uas);
    // console.log(nilai_akhir);
    // console.log(grade);
    // console.log(nilai_sikap);

    var ask = window.confirm("Apakah yakin untuk mengubah nilai?");

    if (ask) {
        window.alert("Nilai berhasil diubah");
    
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.post("/score/update_score/update",
        {
          id_khs : id_khs,
          nilai_harian : nilai_harian,
          nilai_praktek : nilai_praktek,
          nilai_uts : nilai_uts,
          nilai_uas : nilai_uas,
          nilai_akhir : nilai_akhir,
          grade : grade,
          nilai_sikap : nilai_sikap,
          _token: CSRF_TOKEN
        },
        function(data, status){
        //   alert('sukses')
      });

    } else {
        window.alert("Nilai gagal diubah, halaman akan direfresh untuk memastikan data tidak terubah");
        window.location.reload();
    }
}

$(function () {
  $("input").keydown(function () {
    // Save old value.
    if (!$(this).val() || (parseInt($(this).val()) <= 100 && parseInt($(this).val()) >= 0))
    $(this).data("old", $(this).val());
  });
  $("input").keyup(function () {
    // Check correct, else revert back to old value.
    if (!$(this).val() || (parseInt($(this).val()) <= 100 && parseInt($(this).val()) >= 0))
      ;
    else
      $(this).val($(this).data("old"));
  });
});

</script>


@endpush