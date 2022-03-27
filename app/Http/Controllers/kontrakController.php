<?php

namespace App\Http\Controllers;
use App\Models\Jabatan_Pegawai;
use App\Models\Pegawai;
use App\Models\Kontrak;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Requests\kontrakRequest;

class kontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kontrak::join('jabatan_pegawai', 'kontrak.jabatan_id', '=', 'jabatan_pegawai.id')
            ->join('pegawai', 'kontrak.pegawai_id', '=', 'pegawai.id')
            ->select(['kontrak.id', 'pegawai.nama', 'jabatan_pegawai.jabatan', 'kontrak.pegawai_id', 'kontrak.jabatan_id', 'kontrak.kontrak']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $btn = '<a href="#" class="editPegawai" data-id='.$row->id.' data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit fa-fw text-warning"></i></a> &nbsp;
                        <a href="#" data-id='.$row->id.' class="delete"><i class="fa fa-trash fa-fw text-danger"></i></a> &nbsp;';
                        return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('kontrak')) {
                        $instance->where('kontrak', $request->get('kontrak'));
                    }
                    if ($request->get('jabatan_id')) {
                        $instance->where('jabatan_id', $request->get('jabatan_id'));
                    }
                    if (!empty($request->get('search'))) {
                         $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('nama', 'LIKE', "%$search%")
                            ->orWhere('kontrak', 'LIKE', "%$search%");
                        });
                    }
                })
              ->rawColumns(['action'])
              ->make(true);
            }
            return view('kontrak');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJabatan($id)
    {
        $jabatanName = Pegawai::join('jabatan_pegawai', 'pegawai.jabatan_id', '=', 'jabatan_pegawai.id')
        ->select(['pegawai.id','pegawai.jabatan_id', 'jabatan_pegawai.jabatan'])
        ->where("pegawai.id",$id)->first();
        return json_encode($jabatanName);
    }

    public function create(kontrakRequest $request)
    {
        $kontrak = new Kontrak();
        $kontrak->pegawai_id =  $request->pegawai_id;
        $kontrak->jabatan_id =  $request->jabatan_id;
        $kontrak->kontrak =  $request->kontrak;
        $kontrak->save();

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
        $where = array('kontrak.id' => $request->id);
        $kontrak = Kontrak::join('jabatan_pegawai', 'kontrak.jabatan_id', '=', 'jabatan_pegawai.id')
            ->join('pegawai', 'kontrak.pegawai_id', '=', 'pegawai.id')
            ->select(['kontrak.id', 'pegawai.nama', 'jabatan_pegawai.jabatan', 'kontrak.pegawai_id', 'kontrak.jabatan_id', 'kontrak.kontrak'])
            ->where($where)->first();
        return Response()->json($kontrak);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(kontrakRequest $request, $id)
    {
        $kontrak = Kontrak::find($id);
        $kontrak->pegawai_id =  $request->pegawai_id;
        $kontrak->jabatan_id =  $request->jabatan_id;
        $kontrak->kontrak =  $request->kontrak;
        $kontrak->save();

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
        $kontrak = Kontrak::find($id);
        $kontrak->delete();
        return response()->json(['message'=>'success !']);
    }
}
