<?php

namespace App\Http\Controllers;

use App\Http\Requests\RombelRequest;
use App\Models\LogActivity;
use App\Models\Rombel;
use App\Models\Student;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Session;

class RombelController extends Controller
{
    public function ajax()
    {
        Student::all();

        return view('rombel.ajax');
    }

    public function datatable()
    {
        return DataTables::of(Rombel::all())
            ->addColumn('action', function ($rombel) {
                return view('layouts.action._action', [
                    'rombel'        => $rombel,
                    'url_edit'    => route('rombel.edit', $rombel->kode_rombel),
                    'url_destroy' => route('rombel.show', $rombel->kode_rombel),
                ]);
            })
            ->make(true);
    }

    public function datatableRombelSiswa()
    {
        $student = \DB::table('students')
            ->join('majors', 'majors.kode_jurusan', '=', 'students.kode_jurusan')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'students.kode_tahun_akademik')
            ->Leftjoin('users', 'users.id', '=', 'students.user_id')
            ->get();

        return DataTables::of($student)
            ->addColumn('action', function ($student) {
                $action = '<a href="/student/'.$student->nis.'/edit-rombel" class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
                            data-original-title="Ubah Rombel Siswa">
                                <i class="fas fa-pencil-alt"></i>
                            </a>';

                return $action;
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = \DB::table('students')
            ->leftJoin('rombels', 'rombels.kode_rombel', '=', 'students.kode_rombel')
            // ->orderBy('nis', 'asc')
            // ->paginate(5);
            ->get();

        // $data['siswa']  = Student::all();
        $data['rombel'] = Rombel::all();

        return view('rombel.index', compact('list'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rombel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RombelRequest $request)
    {
        $input = $request->all();

        Rombel::create($input);

        // // Insert ke table Log Activities
        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menambahkan data rombel: " . $request->nama_rombel;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penambahan data rombel: '.$request->kode_rombel.' - '.$request->nama_rombel;
        $filename = 'Log Rombel - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been saved!');

        return redirect('rombel');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rombel $rombel)
    {
        return view('rombel.edit', compact('rombel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RombelRequest $request, Rombel $rombel)
    {
        $input = $request->all();

        $rombel->update($input);

        // Insert ke table Log Activities
        // $logActivities = new LogActivity;

        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Mengubah data rombel: " . $request->nama_rombel;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan perubahan data rombel: '.$request->kode_rombel.' - '.$request->nama_rombel;
        $filename = 'Log Rombel - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been updated!');

        return redirect('rombel');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rombel $rombel)
    {
        Rombel::destroy($rombel->kode_rombel);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Menghapus data rombel: " . $rombel->nama_rombel;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan penghapusan data rombel: '.$rombel->kode_rombel.' - '.$rombel->nama_rombel;
        $filename = 'Log Rombel - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('rombel');
    }

    public function update_rombel(Request $request)
    {
        \DB::table('students')
            ->where('nis', $request->nis)
            ->update(['kode_rombel' => $request->rombel]);

        // $logActivities = new LogActivity;
        // $logActivities->user_id = Auth::user()->id;
        // $logActivities->activity_name = "Melakukan perubahan rombel pada siswa dengan NIS: " . $request->nis;
        // $logActivities->save();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan perubahan rombel siswa: '.$request->nisl;
        $filename = 'Log Rombel - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);
    }

    // function search(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $output = '';
    //         $query = $request->get('query');
    //         if ($query != '') {
    //             $data = \DB::table('students')
    //                 ->leftJoin('rombels', 'rombels.kode_rombel', '=', 'students.kode_rombel')
    //                 ->where('nis', 'LIKE', '%' . $query . '%')
    //                 ->orWhere('nama', 'LIKE', '%' . $query . '%')
    //                 ->orderBy('nis', 'asc')
    //                 ->get();
    //         } else {
    //             $data = DB::table('students')
    //                 ->orderBy('nis', 'asc')
    //                 ->get();
    //         }

    //         $total_row = $data->count();
    //         if ($total_row > 0) {
    //             foreach ($data as $row) {
    //                 $output .= '
    //                 <tr>
    //                 <th>' . $row->nis . '</th>
    //                 <th>' . $row->nama . '</th>
    //                 <th>' . '
    //                 <select class="form-control onchange="simpan_rombel(' . $row->nis . ')" id="rombel-' . $row->nis . '"
    //                 name="rombel">
    //                 <option disabled selected>-- Pilih Rombel --</option>';

    //                 foreach ($data as $m) {

    //                     $output .= '<option value="' . $m->kode_rombel . '"
    //                     ' . $m->kode_rombel == $row->kode_rombel ? 'selected' : '' . '>
    //                     ' . $m->kode_rombel . '>' . $m->kode_rombel . '</option>';

    //                     // $output .= '<option>' . $m->kode_rombel . '</option>';
    //                 }

    //                 $output .= '</select>';

    //                 '</th>
    //     </tr>
    //     ';
    //             }
    //         } else {
    //             $output = '
    //    <tr>
    //     <td align="center" colspan="3">No Data Found</td>
    //    </tr>
    //    ';
    //         }
    //         $data = array(
    //             'table_data'  => $output,
    //             'total_data'  => $total_row
    //         );

    //         echo json_encode($data);
    //     }
    // }
}
