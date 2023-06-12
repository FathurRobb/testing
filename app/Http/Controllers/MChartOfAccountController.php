<?php

namespace App\Http\Controllers;

use App\Models\MChartOfAccount;
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
        $datas = MChartOfAccount::get();
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
     * Display the specified resource.
     *
     * @param  \App\Models\MChartOfAccount  $mChartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MChartOfAccount::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MChartOfAccount  $mChartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MChartOfAccount::findOrFail($id);
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
        $this->validate($request, [
            'kategori_id'   =>  'required',
            'kode'          =>  'required|unique:m_chart_of_accounts',
            'nama'          =>  'required|string|max:191' 
        ]);

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
