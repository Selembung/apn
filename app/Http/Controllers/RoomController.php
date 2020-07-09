<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\LogActivity;
use DataTables;
use Session;

class RoomController extends Controller
{
    public function datatable()
    {
        return DataTables::of(Room::all())
            ->addColumn('action', function ($room) {
                return view('layouts.action._action', [
                    'room'        => $room,
                    'url_edit'    => route('room.edit', $room->kode_ruangan),
                    'url_destroy' => route('room.show', $room->kode_ruangan),
                ]);
            })
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('room.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $input = $request->all();

        Room::create($input);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Menambahkan data ruangan: " . $request->nama_ruangan;
        $logActivities->save();

        Session::flash('message', 'Data has been saved!');

        return redirect('room');
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
    public function edit(Room $room)
    {
        return view('room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, Room $room)
    {
        $input = $request->all();

        $room->update($input);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Mengubah data ruangan: " . $request->nama_ruangan;
        $logActivities->save();

        Session::flash('message', 'Data has been updated!');

        return redirect('room');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        Room::destroy($room->kode_ruangan);

        $logActivities = new LogActivity;
        $logActivities->user_id = Auth::user()->id;
        $logActivities->activity_name = "Menghapus data ruangan: " . $room->nama_ruangan;
        $logActivities->save();

        Session::flash('message', 'Data has been deleted!');
        Session::flash('important', true);

        return redirect('room');
    }
}
