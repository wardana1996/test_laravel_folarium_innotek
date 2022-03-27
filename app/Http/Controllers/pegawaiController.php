<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;
use App\Models\Jabatan_Pegawai;
use App\Models\Kontrak;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use App\Imports\pegawaiImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\pegawaiRequest;
use DB;

class pegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = Pegawai::join('jabatan_pegawai', 'pegawai.jabatan_id', '=', 'jabatan_pegawai.id')
            ->select(['pegawai.id', 'pegawai.nama', 'pegawai.email', 'pegawai.alamat', 'pegawai.jabatan_id', 'jabatan_pegawai.jabatan']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $existPegawai = Kontrak::where('pegawai_id',$row->id)->first();
                    if ($row->id == $existPegawai['pegawai_id']){
                        $btn = '<a href="#" class="editPegawai" data-id='.$row->id.' data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit fa-fw text-warning"></i></a> &nbsp;
                        <a href="#" class="noDelete"><i class="fa fa-trash fa-fw text-danger"></i></a> &nbsp;';
                        return $btn;
                    } else {
                        $btn = '<a href="#" class="editPegawai" data-id='.$row->id.' data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit fa-fw text-warning"></i></a> &nbsp;
                        <a href="#" data-id='.$row->id.' class="delete"><i class="fa fa-trash fa-fw text-danger"></i></a> &nbsp;';
                        return $btn;
                    }
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('jabatan_id')) {
                        $instance->where('jabatan_id', $request->get('jabatan_id'));
                    }
                    if (!empty($request->get('search'))) {
                         $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('nama', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                        });
                    }
                })
              ->rawColumns(['action'])
              ->make(true);
            }
            return view('pegawai');
    }

    public function getJabatan(Request $request){
        $search = $request->search;
        if($search == ''){
           $Jabatans = Jabatan_Pegawai::get();
        }else{
           $Jabatans = Jabatan_Pegawai::where('id', 'like', '%' .$search . '%')->get();
        }
  
        $response = array();
        foreach($Jabatans as $jabatan){
           $response[] = array(
                "id"=>$jabatan->id,
                "text"=>$jabatan->jabatan
           );
        }
        return response()->json($response); 
    } 

    public function getNama(Request $request){
        $search = $request->search;
        if($search == ''){
           $Namas = Pegawai::get();
        }else{
           $Namas = Pegawai::where('nama', 'like', '%' .$search . '%')->get();
        }
  
        $response = array();
        foreach($Namas as $nama){
           $response[] = array(
                "id"=>$nama->id,
                "text"=>$nama->nama
           );
        }
        return response()->json($response); 
    } 


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(pegawaiRequest $request)
    {
        $pegawai = new Pegawai();
        $pegawai->jabatan_id =  $request->jabatan_id;
        $pegawai->nama =  $request->nama;
        $pegawai->email =  $request->email;
        $pegawai->alamat =  $request->alamat;
        $pegawai->save();

        return response()->json(['message'=>'success !']);
    }

    function import(Request $request)
    {
        Excel::import(new pegawaiImport, request()->file('file'));
        return back()->with('success', 'Excel Data Imported successfully.');
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
        $where = array('pegawai.id' => $request->id);
        $pegawai = Pegawai::join('jabatan_pegawai', 'pegawai.jabatan_id','jabatan_pegawai.id')
                    ->select(['pegawai.id', 'pegawai.nama', 'pegawai.email', 'pegawai.alamat', 'pegawai.jabatan_id', 'jabatan_pegawai.jabatan'])
                    ->where($where)->first();
        return Response()->json($pegawai);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(pegawaiRequest $request, $id)
    { 
        $pegawai = Pegawai::find($id);
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->nama =  $request->nama;
        $pegawai->email =  $request->email;
        $pegawai->alamat =  $request->alamat;
        $pegawai->save();

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
        $pegawai = Pegawai::find($id);
        $pegawai->delete();
        return response()->json(['message'=>'success !']);
    }
}
