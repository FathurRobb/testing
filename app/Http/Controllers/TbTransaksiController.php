<?php

namespace App\Http\Controllers;

use App\Models\TbTransaksi;
use App\Models\MChartOfAccount;
use App\Models\MKategori;
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
        $kategoris = MKategori::with('chart_of_account')->get();
        return view('transaksi.index', compact('datas','kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coas = MChartOfAccount::get();
        return view("transaksi.create", compact('coas'));
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
            'tanggal'               =>  'required',
            'deskripsi'             =>  'required'
        ]);

        TbTransaksi::create([
            'chart_of_account_id'   =>  $request->chart_of_account_id,
            'tanggal'               =>  $request->tanggal,
            'deskripsi'             =>  $request->deskripsi,
            'debit'                 =>  str_replace('.', '', $request->debit),
            'credit'                =>  $request->credit ? str_replace('.', '', $request->credit) : $request->credit
        ]);

        return response()->json(['success'=>'Transaction saved successfully.']);
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
        return response()->json(['success'=>$data]);
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
        $kategoris = MKategori::with('chart_of_account')->get();
        return view("transaksi.edit", compact('data','kategoris'));
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
            'tanggal'               =>  'required',
            'deskripsi'             =>  'required' 
        ]);

        $m_chart_of_account = TbTransaksi::findOrFail($id);

        $m_chart_of_account->update([
            'chart_of_account_id'   =>  $request->chart_of_account_id,
            'tanggal'               =>  $request->tanggal,
            'deskripsi'             =>  $request->deskripsi,
            'debit'                 =>  str_replace('.', '', $request->debit),
            'credit'                =>  $request->credit ? str_replace('.', '', $request->credit) : $request->credit
        ]);

        return response()->json(['success'=>'Transaction updated successfully.']);
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
        return response()->json(['success'=>'Transaction deleted successfully.']);
    }
}
