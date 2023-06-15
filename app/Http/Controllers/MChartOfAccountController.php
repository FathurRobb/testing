<?php

namespace App\Http\Controllers;

use App\Models\MChartOfAccount;
use App\Models\MKategori;
use Illuminate\Http\Request;

class MChartOfAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = MChartOfAccount::latest()->paginate();
        $kategoris = MKategori::get();
        return view('coa.index', compact('datas','kategoris'));
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
            'kategori_id'   =>  'required',
            'kode'          =>  'required|unique:m_chart_of_accounts',
            'nama'          =>  'required|string|max:191' 
        ]);

        MChartOfAccount::create([
            'kategori_id'   =>  $request->kategori_id,
            'kode'          =>  $request->kode,
            'nama'          =>  $request->nama,
        ]);

        return redirect()->route('coa.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MChartOfAccount  $mChartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validataion = $this->validate($request, [
            'kategori_id'   =>  'required',
            'kode'          =>  'required|unique:m_chart_of_accounts,kode,' . $id,
            'nama'          =>  'required|string|max:191' 
        ]);

        // if($validataion->fails()) {
        //     return redirect()->back();
        // }

        $m_chart_of_account = MChartOfAccount::findOrFail($id);

        $m_chart_of_account->update([
            'kategori_id'   =>  $request->kategori_id,
            'kode'          =>  $request->kode,
            'nama'          =>  $request->nama,
        ]);
        return redirect()->route('coa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MChartOfAccount  $mChartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MChartOfAccount::find($id)->delete();     
        return redirect()->route('coa.index');
    }
}
