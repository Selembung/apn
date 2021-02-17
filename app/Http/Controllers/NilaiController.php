<?php

namespace App\Http\Controllers;

use App\Models\Khs;
use Carbon\Carbon;
use DB;
use Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['siswa'] = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('teachers.guru_id', Auth::user()->id)
            ->where('status', 'Aktif')
            ->select('students.nama AS nama_siswa', 'students.nis', 'khs.*', 'courses.kode_mp', 'courses.nama_mp')
            ->groupBy('nis')
            ->orderBy('nis', 'asc')
            ->get();

        // SELECT *, students.nama as nama_siswa FROM `khs`JOIN students ON students.user_id = khs.user_id JOIN homeroom_teachers on homeroom_teachers.kode_rombel = students.kode_rombel JOIN teachers ON teachers.kode_guru = homeroom_teachers.kode_guru JOIN courses on courses.kode_mp = khs.kode_mp WHERE teachers.guru_id = 4

        return view('nilai.index', $data);
    }

    // Leger Nilai
    public function KHSpdf()
    {
        $data = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('teachers.guru_id', Auth::user()->id)
            ->where('status', 'aktif')
            ->select('students.nama AS nama_siswa', 'students.nis', 'khs.*', 'courses.kode_mp', 'courses.nama_mp', 'homeroom_teachers.kode_rombel')
            ->get();

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetFont('Times', 'B', 20);

        $pdf->Cell(190, 20, 'Leger Nilai '.$data[0]->kode_rombel, 0, 1, 'C');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(10, 10, 'No.', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Nama', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Mata Pelajaran', 1, 0, 'C');
        $pdf->Cell(20, 10, 'P', 1, 0, 'C');
        $pdf->Cell(20, 10, 'K', 1, 0, 'C');
        $pdf->Cell(20, 10, 'S', 1, 1, 'C');
        $pdf->SetFont('Times', '', 12);
        $no = 1;

        foreach ($data as $row) {
            $pdf->Cell(10, 7, $no.'.', 1, 0, 'C');
            $pdf->Cell(50, 7, $row->nama_siswa, 1, 0);
            if ($row->nama_mp == 'Pendidikan Agama dan Budi Pekerti' or $row->nama_mp == 'Pendidikan Pancasila dan Kewarganegaraan' or $row->nama_mp == 'Pendidikan Jasmani, Olahraga dan Kesehatan' or $row->nama_mp == 'Otomatisasi Tata Kelola Sarana dan Prasarana' or $row->nama_mp == 'Pemeliharaan Kelistrikan Kendaraan Ringan' or $row->nama_mp == 'Pendidikan Pancasila dan Kewarganegaraan' or $row->nama_mp == 'Pemeliharaan Sasis dan Pemindah Tenaga Kendaraan Ringan' or $row->nama_mp == 'Pemrograman Web dan Perangkat Bergerak' or $row->nama_mp == 'Sanitasi, Hygiene dan Keselamatan Kerja' or $row->nama_mp == 'Pemeliharaan Mesin Kendaraan Ringan') {
                $pdf->SetFont('Times', '', 10);
                $pdf->Cell(70, 7, $row->nama_mp, 1, 0);
                $pdf->SetFont('Times', '', 12);
            } else {
                $pdf->Cell(70, 7, $row->nama_mp, 1, 0);
            }
            $pdf->Cell(20, 7, $row->nilai_akhir, 1, 0, 'C');
            $pdf->Cell(20, 7, $row->nilai_praktek, 1, 0, 'C');
            if (! $row->nilai_sikap == '') {
                $pdf->Cell(20, 7, $row->nilai_sikap, 1, 1, 'C');
            } else {
                $pdf->Cell(20, 7, '-', 1, 1, 'C');
            }
            $no++;
        }

        $pdf->Output('Leger Nilai '.$data[0]->kode_rombel.'.pdf', 'D');
        exit();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan pencetakan leger nilai pada rombel | '.$data[0]->kode_rombel;
        $filename = 'Log Cetak Rapor - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);
    }

    // Rapor per Siswa
    public function KHSpdfSiswa($nis)
    {
        $khs = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('majors', 'majors.kode_jurusan', '=', 'students.kode_jurusan')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('status', 'aktif')
            ->where('nis', $nis)
            ->select('students.nama AS nama_siswa', 'students.*', 'khs.*', 'courses.kode_mp', 'courses.nama_mp', 'academic_years.tahun_akademik', 'majors.nama_jurusan', 'teachers.nama AS walikelas')
            ->get();

        $khsA = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('majors', 'majors.kode_jurusan', '=', 'students.kode_jurusan')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('status', 'aktif')
            ->where('nis', $nis)
            ->where('muatan', 'A')
            ->select('students.nama AS nama_siswa', 'students.*', 'khs.*', 'courses.kode_mp', 'courses.nama_mp', 'academic_years.tahun_akademik', 'majors.nama_jurusan', 'teachers.nama AS walikelas')
            ->get();

        $khsB = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('majors', 'majors.kode_jurusan', '=', 'students.kode_jurusan')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('status', 'aktif')
            ->where('nis', $nis)
            ->where('muatan', 'B')
            ->select('students.nama AS nama_siswa', 'students.*', 'khs.*', 'courses.kode_mp', 'courses.nama_mp', 'academic_years.tahun_akademik', 'majors.nama_jurusan', 'teachers.nama AS walikelas')
            ->get();

        $khsC = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('majors', 'majors.kode_jurusan', '=', 'students.kode_jurusan')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('status', 'aktif')
            ->where('nis', $nis)
            ->where('muatan', 'C')
            ->select('students.nama AS nama_siswa', 'students.*', 'khs.*', 'courses.kode_mp', 'courses.nama_mp', 'academic_years.tahun_akademik', 'majors.nama_jurusan', 'teachers.nama AS walikelas')
            ->get();

        Fpdf::AddPage();
        Fpdf::SetFont('Times', 'B', 12);

        // Nama Sekolah dan Kelas
        Fpdf::SetFont('Times', '', 12);
        Fpdf::Cell(35, 5, 'Nama Sekolah', 0, 0);
        Fpdf::Cell(3, 5, ' : ', 0, 0);
        Fpdf::SetFont('', 'B');
        Fpdf::Cell(47, 5, 'SMK NEGERI 1 CISARUA', 0, 0);
        Fpdf::Cell(10, 5, '', 0, 0);
        Fpdf::SetFont('', '');
        Fpdf::Cell(35, 5, 'Kelas', 0, 0);
        Fpdf::Cell(10, 5, ' : '.$khs[0]->kode_rombel, 0, 1);

        // Alamat dan Semester
        Fpdf::SetFont('Times', '', 12);
        Fpdf::Cell(35, 5, 'Alamat', 0, 0);
        Fpdf::Cell(50, 5, ' : '.$khs[0]->alamat, 0, 0);
        Fpdf::Cell(10, 5, '', 0, 0);
        Fpdf::Cell(35, 5, 'Semester', 0, 0);
        if ($khs[0]->semester == 1) {
            Fpdf::Cell(10, 5, ' : 1 ( Satu )', 0, 1);
        } elseif ($khs[0]->semester == 2) {
            Fpdf::Cell(10, 5, ' : 2 ( Dua )', 0, 1);
        } elseif ($khs[0]->semester == 3) {
            Fpdf::Cell(10, 5, ' : 1 ( Satu )', 0, 1);
        } elseif ($khs[0]->semester == 4) {
            Fpdf::Cell(10, 5, ' : 2 ( Dua )', 0, 1);
        } elseif ($khs[0]->semester == 5) {
            Fpdf::Cell(10, 5, ' : 1 ( Satu )', 0, 1);
        } elseif ($khs[0]->semester == 6) {
            Fpdf::Cell(10, 5, ' : 2 ( Dua )', 0, 1);
        }

        // Nama Siswa dan Tahun Pelajaran
        Fpdf::SetFont('Times', '', 12);
        Fpdf::Cell(35, 5, 'Nama', 0, 0);
        Fpdf::Cell(3, 5, ' : ', 0, 0);
        Fpdf::SetFont('', 'B');
        Fpdf::Cell(47, 5, $khs[0]->nama_siswa, 0, 0);
        Fpdf::Cell(10, 5, '', 0, 0);
        Fpdf::SetFont('', '');
        Fpdf::Cell(35, 5, 'Tahun Pelajaran', 0, 0);
        Fpdf::Cell(10, 5, ' : '.$khs[0]->tahun_akademik, 0, 1);

        // NISN dan Jurusan
        Fpdf::SetFont('Times', '', 12);
        Fpdf::Cell(35, 5, 'NISN', 0, 0);
        Fpdf::Cell(50, 5, ' : '.$khs[0]->nisn, 0, 0);
        Fpdf::Cell(10, 5, '', 0, 0);
        Fpdf::Cell(35, 5, 'Bidang Keahlian', 0, 0);
        Fpdf::Cell(10, 5, ' : '.$khs[0]->nama_jurusan, 0, 1);

        Fpdf::Cell(10, 5, '', 0, 1);

        Fpdf::Cell(10, 21, 'No', 1, 0, 'C');
        Fpdf::Cell(70, 21, 'Mata Pelajaran', 1, 0, 'C');
        Fpdf::Cell(15, 21, 'Nilai', 1, 0, 'C');
        Fpdf::Cell(40, 21, 'Kompetensi', 1, 0, 'C');
        Fpdf::Cell(55, 21, 'Catatan', 1, 1, 'C');
        Fpdf::SetFont('Times', '', 12);
        $no = 1;
        $noB = 1;
        $noC = 1;

        Fpdf::setFillColor(230, 230, 230);
        Fpdf::Cell(190, 8, 'A. Muatan Nasional', 1, 1, 'B', true);
        foreach ($khsA as $row) {
            if ($row->nama_mp == 'Pendidikan Agama dan Budi Pekerti' or $row->nama_mp == 'Pendidikan Pancasila dan Kewarganegaraan') {
                Fpdf::Cell(10, 30, $no.'.', 1, 0, 'C');
                Fpdf::SetFont('Times', '', 10);
                Fpdf::Cell(70, 30, $row->nama_mp, 1, 0);
                Fpdf::SetFont('Times', '', 12);
                Fpdf::Cell(15, 5, $row->nilai_akhir, 1, 0, 'C');
                Fpdf::Cell(40, 5, 'Pengetahuan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_akhir >= 89 && $row->nilai_akhir <= 100) {
                    Fpdf::Cell(55, 5, 'Sangat terampil memahami seluruh kompetensi', 1, 0);
                } elseif ($row->nilai_akhir >= 76 && $row->nilai_akhir <= 88) {
                    Fpdf::Cell(55, 5, 'Terampil sekali memahami seluruh kompetensi', 1, 0);
                } else {
                    Fpdf::Cell(55, 5, 'Belum Terampil memahami seluruh kompetensi', 1, 0);
                }
                Fpdf::Cell(0, 5, '', 1, 1);

                Fpdf::SetFont('Times', '', 12);
                Fpdf::Cell(80, 5, '', 0, 0);
                Fpdf::Cell(15, 5, $row->nilai_praktek, 1, 0, 'C');
                Fpdf::Cell(40, 5, 'Keterampilan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_praktek >= 89 && $row->nilai_praktek <= 100) {
                    Fpdf::Cell(55, 5, 'Sangat terampil memahami seluruh kompetensi', 1, 1);
                } elseif ($row->nilai_praktek >= 76 && $row->nilai_praktek <= 88) {
                    Fpdf::Cell(55, 5, 'Terampil sekali memahami seluruh kompetensi', 1, 1);
                } else {
                    Fpdf::Cell(55, 5, 'Belum Terampil memahami seluruh kompetensi', 1, 1);
                }

                Fpdf::SetFont('Times', '', 12);
                Fpdf::Cell(80, 5, '', 0, 0);
                Fpdf::Cell(15, 20, $row->nilai_sikap, 1, 0, 'C');
                Fpdf::Cell(40, 20, 'Sosial & Spiritual', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_sikap == 'A') {
                    Fpdf::MultiCell(55, 3.34, 'Baik dalam bersyukur, selalu berdoa sebelum melakukan kegiatan, toleran pada agama yang berbeda dan perlu meningkatkan ketaatan beribadah serta selalu bersikap santun, peduli, percaya diri dan perlu meningkatkan sikap jujur, disiplin, dan tanggung jawab.', 1, 1);
                } elseif ($row->nilai_sikap == 'B') {
                    Fpdf::MultiCell(55, 3.34, 'Baik dalam bersyukur, selalu berdoa sebelum melakukan kegiatan, toleran pada agama yang berbeda dan perlu meningkatkan ketaatan beribadah serta selalu bersikap santun, peduli, percaya diri dan perlu meningkatkan sikap jujur, disiplin, dan tanggung jawab.', 1, 1);
                } else {
                    Fpdf::MultiCell(55, 3.34, 'Cukup dalam bersyukur, selalu berdoa sebelum melakukan kegiatan, toleran pada agama yang berbeda dan perlu meningkatkan ketaatan beribadah serta selalu bersikap santun, peduli, percaya diri dan perlu meningkatkan sikap jujur, disiplin, dan tanggung jawab.', 1, 1);
                }
                Fpdf::SetFont('Times', '', 12);
            } else {
                Fpdf::Cell(10, 15, $no.'.', 1, 0, 'C');
                Fpdf::Cell(70, 15, $row->nama_mp, 1, 0);
                Fpdf::Cell(15, 7.5, $row->nilai_akhir, 1, 0, 'C');
                Fpdf::Cell(40, 7.5, 'Pengetahuan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_akhir >= 89 && $row->nilai_akhir <= 100) {
                    Fpdf::Cell(55, 7.5, 'Sangat terampil memahami seluruh kompetensi', 1, 0);
                } elseif ($row->nilai_akhir >= 76 && $row->nilai_akhir <= 88) {
                    Fpdf::Cell(55, 7.5, 'Terampil sekali memahami seluruh kompetensi', 1, 0);
                } else {
                    Fpdf::Cell(55, 7.5, 'Belum Terampil memahami seluruh kompetensi', 1, 0);
                }
                Fpdf::Cell(0, 7.5, '', 1, 1);

                Fpdf::SetFont('Times', '', 12);
                Fpdf::Cell(80, 7.5, '', 0, 0);
                Fpdf::Cell(15, 7.5, $row->nilai_praktek, 1, 0, 'C');
                Fpdf::Cell(40, 7.5, 'Keterampilan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_praktek >= 89 && $row->nilai_praktek <= 100) {
                    Fpdf::Cell(55, 7.5, 'Sangat terampil memahami seluruh kompetensi', 1, 1);
                } elseif ($row->nilai_praktek >= 76 && $row->nilai_praktek <= 88) {
                    Fpdf::Cell(55, 7.5, 'Terampil sekali memahami seluruh kompetensi', 1, 1);
                } else {
                    Fpdf::Cell(55, 7.5, 'Belum Terampil memahami seluruh kompetensi', 1, 1);
                }
                Fpdf::SetFont('Times', '', 12);
            }

            $no++;
        }

        Fpdf::Cell(190, 8, 'B. Muatan Kewilayahan', 1, 1, 'B', true);
        foreach ($khsB as $row) {
            Fpdf::Cell(10, 15, $noB.'.', 1, 0, 'C');
            if ($row->nama_mp == 'Pendidikan Jasmani, Olahraga dan Kesehatan') {
                Fpdf::SetFont('Times', '', 10);
                Fpdf::Cell(70, 15, $row->nama_mp, 1, 0);
                Fpdf::SetFont('Times', '', 12);
                Fpdf::Cell(15, 7.5, $row->nilai_akhir, 1, 0, 'C');
                Fpdf::Cell(40, 7.5, 'Pengetahuan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_akhir >= 89 && $row->nilai_akhir <= 100) {
                    Fpdf::Cell(55, 7.5, 'Sangat terampil memahami seluruh kompetensi', 1, 0);
                } elseif ($row->nilai_akhir >= 76 && $row->nilai_akhir <= 88) {
                    Fpdf::Cell(55, 7.5, 'Terampil sekali memahami seluruh kompetensi', 1, 0);
                } else {
                    Fpdf::Cell(55, 7.5, 'Belum Terampil memahami seluruh kompetensi', 1, 0);
                }
                Fpdf::Cell(0, 7.5, '', 1, 1);

                Fpdf::SetFont('Times', '', 12);
                Fpdf::Cell(80, 7.5, '', 0, 0);
                Fpdf::Cell(15, 7.5, $row->nilai_praktek, 1, 0, 'C');
                Fpdf::Cell(40, 7.5, 'Keterampilan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_praktek >= 89 && $row->nilai_praktek <= 100) {
                    Fpdf::Cell(55, 7.5, 'Sangat terampil memahami seluruh kompetensi', 1, 1);
                } elseif ($row->nilai_praktek >= 76 && $row->nilai_praktek <= 88) {
                    Fpdf::Cell(55, 7.5, 'Terampil sekali memahami seluruh kompetensi', 1, 1);
                } else {
                    Fpdf::Cell(55, 7.5, 'Belum Terampil memahami seluruh kompetensi', 1, 1);
                }
                Fpdf::SetFont('Times', '', 12);
            } else {
                Fpdf::Cell(70, 15, $row->nama_mp, 1, 0);
                Fpdf::Cell(15, 7.5, $row->nilai_akhir, 1, 0, 'C');
                Fpdf::Cell(40, 7.5, 'Pengetahuan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_akhir >= 89 && $row->nilai_akhir <= 100) {
                    Fpdf::Cell(55, 7.5, 'Sangat terampil memahami seluruh kompetensi', 1, 0);
                } elseif ($row->nilai_akhir >= 76 && $row->nilai_akhir <= 88) {
                    Fpdf::Cell(55, 7.5, 'Terampil sekali memahami seluruh kompetensi', 1, 0);
                } else {
                    Fpdf::Cell(55, 7.5, 'Belum Terampil memahami seluruh kompetensi', 1, 0);
                }
                Fpdf::Cell(0, 7.5, '', 1, 1);

                Fpdf::SetFont('Times', '', 12);
                Fpdf::Cell(80, 7.5, '', 0, 0);
                Fpdf::Cell(15, 7.5, $row->nilai_praktek, 1, 0, 'C');
                Fpdf::Cell(40, 7.5, 'Keterampilan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_praktek >= 89 && $row->nilai_praktek <= 100) {
                    Fpdf::Cell(55, 7.5, 'Sangat terampil memahami seluruh kompetensi', 1, 1);
                } elseif ($row->nilai_praktek >= 76 && $row->nilai_praktek <= 88) {
                    Fpdf::Cell(55, 7.5, 'Terampil sekali memahami seluruh kompetensi', 1, 1);
                } else {
                    Fpdf::Cell(55, 7.5, 'Belum Terampil memahami seluruh kompetensi', 1, 1);
                }
                Fpdf::SetFont('Times', '', 12);
            }
            $noB++;
        }

        Fpdf::Cell(190, 8, 'C. Muatan Peminatan Kejuruan', 1, 1, 'B');
        Fpdf::Cell(10, 8, '', 1, 0, 'C', true);
        Fpdf::Cell(70, 8, 'Kompetensi Keahlian', 1, 0, 'B', true);
        Fpdf::Cell(15, 8, '', 1, 0, 'C', true);
        Fpdf::Cell(40, 8, '', 1, 0, 'C', true);
        Fpdf::Cell(55, 8, '', 1, 1, 'C', true);
        foreach ($khsC as $row) {
            Fpdf::Cell(10, 15, $noC.'.', 1, 0, 'C');
            if ($row->nama_mp == 'Pendidikan Jasmani, Olahraga dan Kesehatan') {
                Fpdf::SetFont('Times', '', 8);
                Fpdf::Cell(70, 15, $row->nama_mp, 1, 0);
                Fpdf::SetFont('Times', '', 12);
                Fpdf::Cell(15, 7.5, $row->nilai_akhir, 1, 0, 'C');
                Fpdf::Cell(40, 7.5, 'Pengetahuan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_akhir >= 89 && $row->nilai_akhir <= 100) {
                    Fpdf::Cell(55, 7.5, 'Sangat terampil memahami seluruh kompetensi', 1, 0);
                } elseif ($row->nilai_akhir >= 76 && $row->nilai_akhir <= 88) {
                    Fpdf::Cell(55, 7.5, 'Terampil sekali memahami seluruh kompetensi', 1, 0);
                } else {
                    Fpdf::Cell(55, 7.5, 'Belum Terampil memahami seluruh kompetensi', 1, 0);
                }
                Fpdf::Cell(0, 7.5, '', 1, 1);

                Fpdf::SetFont('Times', '', 12);
                Fpdf::Cell(80, 7.5, '', 0, 0);
                Fpdf::Cell(15, 7.5, $row->nilai_praktek, 1, 0, 'C');
                Fpdf::Cell(40, 7.5, 'Keterampilan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_praktek >= 89 && $row->nilai_praktek <= 100) {
                    Fpdf::Cell(55, 7.5, 'Sangat terampil memahami seluruh kompetensi', 1, 1);
                } elseif ($row->nilai_praktek >= 76 && $row->nilai_praktek <= 88) {
                    Fpdf::Cell(55, 7.5, 'Terampil sekali memahami seluruh kompetensi', 1, 1);
                } else {
                    Fpdf::Cell(55, 7.5, 'Belum Terampil memahami seluruh kompetensi', 1, 1);
                }
                Fpdf::SetFont('Times', '', 12);
            } else {
                Fpdf::Cell(70, 15, $row->nama_mp, 1, 0);
                Fpdf::Cell(15, 7.5, $row->nilai_akhir, 1, 0, 'C');
                Fpdf::Cell(40, 7.5, 'Pengetahuan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_akhir >= 89 && $row->nilai_akhir <= 100) {
                    Fpdf::Cell(55, 7.5, 'Sangat terampil memahami seluruh kompetensi', 1, 0);
                } elseif ($row->nilai_akhir >= 76 && $row->nilai_akhir <= 88) {
                    Fpdf::Cell(55, 7.5, 'Terampil sekali memahami seluruh kompetensi', 1, 0);
                } else {
                    Fpdf::Cell(55, 7.5, 'Belum Terampil memahami seluruh kompetensi', 1, 0);
                }
                Fpdf::Cell(0, 7.5, '', 1, 1);

                Fpdf::SetFont('Times', '', 12);
                Fpdf::Cell(80, 7.5, '', 0, 0);
                Fpdf::Cell(15, 7.5, $row->nilai_praktek, 1, 0, 'C');
                Fpdf::Cell(40, 7.5, 'Keterampilan', 1, 0);

                Fpdf::SetFont('Times', '', 7.8);
                if ($row->nilai_praktek >= 89 && $row->nilai_praktek <= 100) {
                    Fpdf::Cell(55, 7.5, 'Sangat terampil memahami seluruh kompetensi', 1, 1);
                } elseif ($row->nilai_praktek >= 76 && $row->nilai_praktek <= 88) {
                    Fpdf::Cell(55, 7.5, 'Terampil sekali memahami seluruh kompetensi', 1, 1);
                } else {
                    Fpdf::Cell(55, 7.5, 'Belum Terampil memahami seluruh kompetensi', 1, 1);
                }
                Fpdf::SetFont('Times', '', 12);
            }
            $noC++;
        }

        // Tanggal;
        $date = Carbon::now()->translatedFormat('d F Y');

        // Footer
        Fpdf::Cell(30, 20, '', 0, 1);
        Fpdf::Cell(140, 5, '', 0, 0);
        Fpdf::Cell(40, 5, 'Cisarua, '.$date, 0, 1);
        Fpdf::Cell(20, 5, 'Mengetahui:', 0, 1);
        Fpdf::Cell(140, 5, 'Kepala Sekolah,', 0, 0);
        Fpdf::Cell(20, 5, 'Wali Kelas,', 0, 1);
        Fpdf::SetFont('', 'BU');
        Fpdf::Cell(140, 50, 'Edi Gunawan, S.Pd.,M.Pd.', 0, 0);
        Fpdf::Cell(20, 50, $khs[0]->walikelas, 0, 1);
        Fpdf::SetFont('', '');
        Fpdf::Cell(20, -40, '197209282005011000', 0, 0);

        Fpdf::Output($khs[0]->nis.' - '.$khs[0]->nama_siswa.'.pdf', 'D');
        exit();

        // Log Aktivitas di simpan ke file log
        $logActivities = Carbon::now()->translatedFormat('l, d F Y G:i:s').date(' T \| ').'ID User: '.Auth::user()->id.' | Melakukan pencetakan rapor siswa | '.$khs[0]->nis.' - '.$khs[0]->nama_siswa;
        $filename = 'Log Cetak Rapor - '.date('Y-m-d').'.log';
        Storage::disk('activityLog')->append($filename, $logActivities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nis)
    {
        $data['student'] = \DB::table('students')->get();

        $data['siswa'] = \DB::table('khs')
            ->join('students', 'students.user_id', '=', 'khs.user_id')
            ->join('homeroom_teachers', 'homeroom_teachers.kode_rombel', '=', 'students.kode_rombel')
            ->join('teachers', 'teachers.kode_guru', '=', 'homeroom_teachers.kode_guru')
            ->join('courses', 'courses.kode_mp', '=', 'khs.kode_mp')
            ->join('academic_years', 'academic_years.kode_tahun_akademik', '=', 'khs.kode_tahun_akademik')
            ->where('nis', $nis)
            ->where('status', 'Aktif')
            ->select('students.nama AS nama_siswa', 'students.nis', 'khs.*', 'homeroom_teachers.*', 'teachers.*', 'courses.*')
            ->get();

        return view('nilai.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
