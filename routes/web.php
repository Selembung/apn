<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::get('/404-error', function () {
	return view('/error/index');
});

Auth::routes();

Route::group(['middleware' => ['auth', 'checkRole:Admin,guru,siswa']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
});

// Datatables Admin
Route::group(['middleware' => ['auth', 'checkRole:Admin']], function () {
	Route::get('/home/datatable', 'HomeController@datatable')->name('table.kbm');

	Route::get('/course/datatable', 'CourseController@datatable')->name('table.course');
	Route::get('/teacher/datatable', 'TeacherController@datatable')->name('table.teacher');
	Route::get('/academic-year/datatable', 'AcademicYearController@datatable')->name('table.academic-year');
	Route::get('/major/datatable', 'MajorController@datatable')->name('table.major');
	Route::get('/curriculum/datatable', 'CurriculumController@datatable')->name('table.curriculum');
	Route::get('/student/datatable', 'StudentController@datatable')->name('table.student');
	Route::get('/course-schedule/datatable', 'CourseScheduleController@datatable')->name('table.course-schedule');
	Route::get('/course-hour/datatable', 'CourseHourController@datatable')->name('table.course-hour');
	Route::get('/room/datatable', 'RoomController@datatable')->name('table.room');
	Route::get('/score/datatable', 'ScoreController@datatable')->name('table.score');
	Route::get('/rombel/datatable', 'RombelController@datatable')->name('table.rombel');
	Route::get('/rombel/datatableRombelSiswa', 'RombelController@datatableRombelSiswa')->name('table.rombel-siswa');
	Route::get('/homeroom-teacher/datatable', 'HomeroomTeacherController@datatable')->name('table.homeroom-teacher');
	Route::get('/log-activity/datatable', 'LogActivityController@datatable')->name('table.log-activity');
});

// Datatables Guru
Route::group(['middleware' => ['auth', 'checkRole:guru']], function () {
	Route::get('/teaching-schedule/datatable', 'TeacherController@datatableTeaching')->name('table.teachingSchedule');
});

// Datatables Siswa
Route::group(['middleware' => ['auth', 'checkRole:siswa']], function () {
	// Datatable
	Route::get('/krs/datatable', 'KrsController@datatable')->name('table.krs');
	Route::get('/khs/datatable', 'KhsController@datatable')->name('table.khs');
});

Route::group(['middleware' => ['auth', 'checkRole:Admin,guru,siswa']], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['middleware' => ['auth', 'checkRole:guru']], function () {
	Route::get('/teaching-schedule', 'TeacherController@teachingSchedule');
	Route::get('/score/{id}/{semester}', 'ScoreController@index');

	// Tidak menggunakan Editable
	Route::post('/score/update_score/update/', 'ScoreController@update_score');
	// Menggunakan Editable
	// Route::post('/score/{id}/editablenilai', 'ScoreController@editablenilai');

	Route::resource('/score-homeroom', 'NilaiController');
	Route::get('/score-homeroom/{nis}', 'NilaiController@show');
	Route::get('/cetak', 'NilaiController@KHSpdf');
	Route::get('/cetak-rapor/{nis}', 'NilaiController@KHSpdfSiswa');
});

Route::group(['middleware' => ['auth', 'checkRole:siswa']], function () {
	Route::post('/krs/tambahKrs', 'KrsController@tambahKrs');
	Route::get('/krs/tampilKrs', 'KrsController@tampilKrs');
	Route::post('/krs/hapusKrs', 'KrsController@hapusKrs');
	Route::get('/krs/selesai', 'KrsController@selesai');
	Route::resource('/krs', 'KrsController');
	Route::resource('/khs', 'KhsController');
	Route::get('/print', 'KhsController@KHSpdf');
});

Route::group(['middleware' => ['auth', 'checkRole:Admin']], function () {
	Route::resource('/course', 'CourseController');
	Route::resource('/teacher', 'TeacherController');
	Route::resource('/academic-year', 'AcademicYearController');
	Route::resource('/student', 'StudentController');
	Route::resource('/major', 'MajorController');
	Route::resource('/curriculum', 'CurriculumController');
	Route::resource('/student', 'StudentController');
	Route::resource('/course-schedule', 'CourseScheduleController');
	Route::resource('/course-hour', 'CourseHourController');
	Route::resource('/room', 'RoomController');
	Route::resource('/homeroom-teacher', 'HomeroomTeacherController');

	Route::get('/student/{student}/edit-rombel', 'StudentController@editRombel');
	// Route::get('/rombel/search', 'RombelController@search')->name('rombel.search');
	Route::resource('/rombel', 'RombelController');
	Route::post('/student/update_rombel/update', 'RombelController@update_rombel');
	Route::get('/log-activity', 'LogActivityController@index');
	Route::get('/log-activity/{filename}', [
		'as' => 'log-activity.show',
		'uses' => 'LogActivityController@show'
	]);

	Route::get('/log-activity/{filename}/download', [
		'as' => 'log-activity.download',
		'uses' => 'LogActivityController@download'
	]);
});
