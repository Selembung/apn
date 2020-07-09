<?php

namespace App\Http\Controllers;

use App\Http\Requests\RombelRequest;
use App\Rombel;
use App\Student;
use Illuminate\Support\Facades\Auth;
use App\LogActivity;
use Illuminate\Http\Request;
use DataTables;
use Session;
use Illuminate\Support\Facades\Response;

class RombelController extends Controller
{
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = \DB::table('students')
            ->leftJoin('rombels', 'rombels.kode_rombel', '=', 'students.kode_rombel')
            ->orderBy('nis', 'asc')
            ->paginate(5);

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

        // Insert ke table Log Activities
        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Menambahkan data rombel: " . $request->nama_rombel;
        $logActivities->save();

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
        $logActivities = new LogActivity;

        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Mengubah data rombel: " . $request->nama_rombel;
        $logActivities->save();


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

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Menghapus data rombel: " . $rombel->nama_rombel;
        $logActivities->save();

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('rombel');
    }

    public function update_rombel(Request $request)
    {
        $rombel = \DB::table('students')
            ->where('nis', $request->nis)
            ->update(['kode_rombel' => $request->rombel]);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Melakukan perubahan rombel pada siswa dengan NIS: " . $request->nis;
        $logActivities->save();
    }

    // public function search(Request $request)
    // {
    //     $data['rombel'] = Rombel::all();

    //     $keyword = $request->input('search');
    //     $query = \DB::table('students')
    //         ->leftJoin('rombels', 'rombels.kode_rombel', '=', 'students.kode_rombel')
    //         ->where('nis', 'LIKE', '%' . $keyword . '%')
    //         ->orWhere('nama', 'LIKE', '%' . $keyword . '%');

    //     $list = $query->paginate(5);
    //     $pagination = $list->appends($request->except('page'));

    //     return view('rombel.index', compact('keyword', 'list', 'pagination'), $data);
    // }

    function action(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = \DB::table('students')
                    ->leftJoin('rombels', 'rombels.kode_rombel', '=', 'students.kode_rombel')
                    ->where('nis', 'LIKE', '%' . $query . '%')
                    ->orWhere('nama', 'LIKE', '%' . $query . '%')
                    ->orderBy('nis', 'asc')
                    ->get();
            } else {
                $data = DB::table('students')
                    ->orderBy('nis', 'asc')
                    ->get();
            }


            $snis = '{{ $row->nis }}';
            $selected = "? 'selected' : ''";

            $rombel = Rombel::all();

            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr>
                    <th>' . $row->nis . '</th>
                    <th>' . $row->nama . '</th>
                    <th>' . '
                    <select class="form-control onchange="simpan_rombel(' . $snis . ')" id="rombel-{{' . $row->nis . '}}"
                    name="rombel">';

                    foreach ($rombel as $m) {

                        $output .= '<option value="{{' . $m->kode_rombel . '}}" {{' . $m->kode_rombel == $row->kode_rombel ? ' selected' : '' . '}}>'
                            . $m->kode_rombel .
                            '</option>';

                        $output .= '<option>' . $m->kode_rombel . '</option>';
                    }

                    $output .= '</select>';

                    '</th>
        </tr>
        ';
                }
            } else {
                $output = '
       <tr>
        <td align="center" colspan="3">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }
}
