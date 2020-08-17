@extends('layouts.app', [
'title' => 'Log Aktivitas',
'activePage' => 'logActivity'
])

@section('content')

@include('layouts.headers.header', [
'bgGradient' => 'logActivity'
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
                            <h3 class="mb-0">Log Aktivitas</h3>
                        </div>
                        {{-- <div class="col-6 text-right">
                            <a href="/log-activity/create" class="btn btn-sm btn-neutral btn-round btn-icon"
                                data-toggle="tooltip" data-original-title="Add Log Aktivitas">
                                <span class="btn-inner--icon"><i class="fas fa-swatchbook"></i></span>
                                <span class="btn-inner--text">Add</span>
                            </a>
                        </div> --}}
                    </div>
                </div>

                <div class="table-responsive table-hover px-3 pt-3 pb-3">
                    <table class="table align-items-center table-flush" id="">
                        <div class="row">
                        </div>
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama File</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Waktu</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logFiles as $key => $logFile)
                            <tr>
                                <td class="text-center">
                                    {{ ($logFiles->currentpage()-1) * $logFiles->perpage() + $loop->index + 1 }}
                                </td>

                                <td>{{ $logFile->getFilename() }}</td>

                                @if ($logFile->getSize() >= 1073741824)
                                <td class="text-center">{{ number_format($logFile->getSize() / 1073741824, 2) . ' GB' }}
                                </td>
                                @elseif ($logFile->getSize() >= 1048576)
                                <td class="text-center">{{ number_format($logFile->getSize() / 1048576, 2) . ' ,B' }}
                                </td>
                                @elseif ($logFile->getSize() >= 1024)
                                <td class="text-center">{{ number_format($logFile->getSize() / 1024, 2) . ' KB' }}</td>
                                @elseif ($logFile->getSize() > 1)
                                <td class="text-center">{{ $logFile->getSize() . ' bytes' }}</td>
                                @elseif ($logFile->getSize() == 1)
                                <td class="text-center">{{ $logFile->getSize() . ' byte' }}</td>
                                @else
                                <td class="text-center">{{ '0 bytes' }}</td>
                                @endif

                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse(date('Y-m-d H:i:s', $logFile->getMTime()))->diffForHumans() }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('log-activity.show', $logFile->getFilename()) }}"
                                        title="Show file {{ $logFile->getFilename() }}"
                                        class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
                                        data-original-title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('log-activity.download', $logFile->getFilename()) }}"
                                        title="Download file {{ $logFile->getFilename() }}"
                                        class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
                                        data-original-title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="{{ route('log-activity.delete', $logFile->getFilename()) }}"
                                        title="Delete file {{ $logFile->getFilename() }}"
                                        class="btn btn-sm btn-danger btn-round btn-icon" data-toggle="tooltip"
                                        data-original-title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No Log File Exists</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama File</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Waktu</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="">
                        <div class="mt-4 h4 font-weight-light">
                            Showing {{($logFiles->currentpage()-1)*$logFiles->perpage()+1}} to
                            {{$logFiles->currentpage()*$logFiles->perpage()}}
                            of {{$logFiles->total()}} entries
                        </div>
                        <div class="float-right" style="margin-top: -40px">
                            {!! $logFiles->setPath('log-activity')->render() !!}
                        </div>
                    </div>
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
        ajax: { 
            url: '{{ route("table.log-activity") }}',
            // data:{from_date:from_date, to_date:to_date}
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            // {data: 'role', name: 'role', "sClass": "font-weight-bold text-default"},
            // {data: 'getFilename', name: 'getFilename', "sClass": "font-weight-bold text-default"},
            // {data: 'activity_name', name: 'activity_name'},
            // {data: 'created_at', name: 'created_at', "sClass": "text-center"},
            // {data: 'waktuTerakhir', name: 'waktuTerakhir', "sClass": "text-center"},
        ],
        "order": [[ 4, 'desc' ]],
    });

    $('#from_date').change(function () {
        table.column($(this).data('column'))
            .search($(this).val())
            .draw();
            
    });

    $('.datepicker').datepicker({
    format: "yyyy-mm-dd"
    });

</script>

@endpush