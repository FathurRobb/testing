<?php

namespace App\Http\Controllers;

use App\Models\MKategori;
use Illuminate\Http\Request;
use DataTables;

class MKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = MKategori::latest()->get();
            return DataTables::of($datas)
                            ->addIndexColumn()
                            ->addColumn('action', function ($row) {
                                $btn = '<a type="button" class="btn btn-outline-success btn-sm" id="editButton" data-toggle="modal" data-target="#editModal" data-attr="kategori/'.$row->id.'/edit">
                                            <i class="material-icons" style="color:#4caf50;">edit</i>
                                        </a>';
                                $btn = $btn.'<button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="'.$row->id.'" data-kategorinama="'.$row->nama.'">
                                            <i class="material-icons">delete</i>
                                        </button>'; 
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
        return view('kategori.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama'  =>  'required|string|max:191',
            'type'  =>  'required',
        ]);

        MKategori::create($request->all());
        return response()->json(['success'=>'Category saved successfully.']);
    }

    public function edit($id)
    {
        $data = MKategori::findOrFail($id);
        return view('kategori.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MKategori  $mKategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama'  =>  'required|string|max:191',
            'type'  =>  'required',
        ]);

        $data = MKategori::find($id)->update($request->all());
        return response()->json(['success'=>'Category updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MKategori  $mKategori
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MKategori::find($id)->delete();
        return response()->json(['success'=>'Category deleted successfully.']);
    }
}
