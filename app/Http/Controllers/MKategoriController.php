<?php

namespace App\Http\Controllers;

use App\Models\MKategori;
use Illuminate\Http\Request;

class MKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = MKategori::get();
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
        $this->validate($request, [
            'nama'  =>  'required|string|max:191',
        ]);

        MKategori::create($request->all());
        return redirect()->route('kategori.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MKategori  $mKategori
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MKategori::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MKategori  $mKategori
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MKategori::findOrFail($id);
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
        ]);

        $data = MKategori::find($id)->update($request->all());

        return redirect()->route('kategori.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MKategori  $mKategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(MKategori $mKategori)
    {
        MKategori::find($id)->delete();
        
        return redirect()->route('kategori.index');
    }
}
