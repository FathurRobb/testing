<?php

namespace App\Http\Controllers;

use App\Models\MChartOfAccount;
use App\Models\MKategori;
use Illuminate\Http\Request;
use DataTables;

class MChartOfAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = MChartOfAccount::with('kategori')->latest()->get();
            return DataTables::of($datas)
                            ->addIndexColumn()
                            ->rawColumns(['action'])
                            ->make(true);
        }
        $kategoris = MKategori::get();
        return view('coa.index', compact('kategoris'));
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

        return response()->json(['success'=>'Chart of Accound saved successfully.']);
    }

    public function show($id)
    {
        $data = MChartOfAccount::findOrFail($id);
        return response()->json(['success'=>$data]);
    }

    public function edit($id)
    {
        $data = MChartOfAccount::findOrFail($id);
        $kategoris = MKategori::get();
        return view('coa.edit', compact('data','kategoris'));
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
        $validation = $this->validate($request, [
            'kategori_id'   =>  'required',
            'kode'          =>  'required|unique:m_chart_of_accounts,kode,' . $id,
            'nama'          =>  'required|string|max:191' 
        ]);

        $m_chart_of_account = MChartOfAccount::findOrFail($id);

        $m_chart_of_account->update([
            'kategori_id'   =>  $request->kategori_id,
            'kode'          =>  $request->kode,
            'nama'          =>  $request->nama,
        ]);
        return response()->json(['success'=>'Chart of Account updated successfully.']);
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
        return response()->json(['success'=>'Chart of Account deleted successfully.']);
    }
}
