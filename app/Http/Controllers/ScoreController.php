<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScoreRequest;
use App\Score;
use App\Khs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\LogActivity;
use Carbon\Carbon;
use Session;
use DataTables;
use Storage;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_jadwal, $semester)
    {
        $schedule = \DB::table('course_schedules')
            ->join('teachers', 'teachers.guru_id', '=', 'course_schedules.user_id')
            ->join('courses', 'courses.kode_mp', '=', 'course_schedules.kode_mp')
            ->where('id', $id_jadwal)->first();

        $data['siswa'] = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->where('khs.guru_id', $schedule->user_id)
            ->where('khs.kode_mp', $schedule->kode_mp)
            ->where('semester_aktif', $semester)
            ->orderBy('nis')
            ->get();

        $data['schedule'] = $schedule;


        return view('score.index', $data);
    }

    public function update_score(Request $request)
    {
        $score = Khs::where('id', $request->id_khs)
            ->update([
                'nilai_harian'  => $request->nilai_harian,
                'nilai_praktek' => $request->nilai_praktek,
                'nilai_uts'     => $request->nilai_uts,
                'nilai_uas'     => $request->nilai_uas,
                'nilai_akhir'   => $request->nilai_akhir,
                'grade'         => $request->grade,
                'nilai_sikap'   => $request->nilai_sikap,
            ]);

        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s') . date(' T \| ') . 'ID User: ' . Auth::user()->id . " | Melakukan perubahan nilai pada siswa dengan ID KHS: " . $request->id_khs;
        $filename = 'logPenilaian-' . date('Y-m-d') . '.log';
        Storage::disk('activityLog')->append($filename, $logActivities);
    }
}
