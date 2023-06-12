<?php

namespace App\Http\Controllers;

use App\Models\TbTransaksi;
use Illuminate\Http\Request;

class TbTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = TbTransaksi::get();
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
            'chart_of_account_id'   =>  'required',
            'tanggal'               =>  'required|unique:m_chart_of_accounts',
            'deskripsi'             =>  'required|string|max:191' 
        ]);

        TbTransaksi::create([
            'chart_of_account_id'   =>  $request->chart_of_account_id,
            'tanggal'               =>  $request->tanggal,
            'deskripsi'             =>  $request->deskripsi,
            'debit'                 =>  $request->debit,
            'credit'                =>  $request->credit
        ]);

        return redirect()->route('transaksi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TbTransaksi  $tbTransaksi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = TbTransaksi::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TbTransaksi  $tbTransaksi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = TbTransaksi::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TbTransaksi  $tbTransaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'chart_of_account_id'   =>  'required',
            'tanggal'               =>  'required|unique:m_chart_of_accounts',
            'deskripsi'             =>  'required|string|max:191' 
        ]);

        $m_chart_of_account = TbTransaksi::findOrFail($id);

        $m_chart_of_account->update([
            'chart_of_account_id'   =>  $request->chart_of_account_id,
            'tanggal'               =>  $request->tanggal,
            'deskripsi'             =>  $request->deskripsi,
            'debit'                 =>  $request->debit,
            'credit'                =>  $request->credit
        ]);

        return redirect()->route('transaksi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TbTransaksi  $tbTransaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TbTransaksi::find($id)->delete();
        
        return redirect()->route('transaksi.index');
    }
}
