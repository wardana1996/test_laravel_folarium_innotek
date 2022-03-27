<?php

namespace App\Http\Controllers;
use App\Models\Jabatan_Pegawai;
use DataTables;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use App\Http\Requests\jabatanRequest;

class jabatanPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Jabatan_Pegawai::orderBy("id", "desc")->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $existJabatan = Kontrak::where('jabatan_id',$row->id)->first();
                    if ($row->id == $existJabatan['jabatan_id']){
                        $btn = '<a href="#" class="editPegawai" data-id='.$row->id.' data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit fa-fw text-warning"></i></a> &nbsp;
                        <a href="#" class="noDelete"><i class="fa fa-trash fa-fw text-danger"></i></a> &nbsp;';
                        return $btn;
                    } else {
                        $btn = '<a href="#" class="editPegawai" data-id='.$row->id.' data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit fa-fw text-warning"></i></a> &nbsp;
                        <a href="#" data-id='.$row->id.' class="delete"><i class="fa fa-trash fa-fw text-danger"></i></a> &nbsp;';
                        return $btn;
                    }
                })
              ->rawColumns(['action'])
              ->make(true);
            }
            return view('jabatan_pegawai');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(jabatanRequest $request)
    {
        $jabatan = new Jabatan_Pegawai();
        $jabatan->jabatan =  $request->jabatan;
        $jabatan->save();

        return response()->json(['message'=>'success !']);
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
    public function edit(Request $request, $id)
    {
        $where = array('id' => $request->id);
        $jabatan = Jabatan_Pegawai::where($where)->first();
        return Response()->json($jabatan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(jabatanRequest $request, $id)
    {
        $jabatan = Jabatan_Pegawai::find($id);
        $jabatan->jabatan =  $request->jabatan;
        $jabatan->save();

        return response()->json(['message'=>'success !']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $jabatan = Jabatan_Pegawai::find($id);
        $jabatan->delete();
        return response()->json(['message'=>'success !']);
    }
}
