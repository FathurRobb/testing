<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportLaporan;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index() {
        $datas = DB::table('m_kategoris')
                        ->join('m_chart_of_accounts', 'm_chart_of_accounts.kategori_id', '=', 'm_kategoris.id')
                        ->join('tb_transaksis', 'tb_transaksis.chart_of_account_id', '=', 'm_chart_of_accounts.id')
                        ->select('m_kategoris.nama', DB::raw("DATE_FORMAT(tb_transaksis.tanggal, '%Y-%m') AS tanggal"), DB::raw('SUM(tb_transaksis.credit)-SUM(tb_transaksis.debit) AS amount'))
                        ->groupBy('m_chart_of_accounts.kategori_id', DB::raw("DATE_FORMAT(tb_transaksis.tanggal, '%Y-%m')"))
                        ->paginate(10);
        
        $recordsProfitByName = [];
        $tanggals = [];
        $namas = [];
        foreach ($datas as $record) {
            $recordsProfitByName[$record->nama][$record->tanggal] = $record->amount;
            if (!in_array($record->tanggal, $tanggals, true)) {
                array_push($tanggals, $record->tanggal);
            }
            if (!in_array($record->nama, $namas, true)) {
                array_push($namas, $record->nama);
            }
        }
        // $checkDate = [];
        // foreach ($tanggals as $tgl) {
        //     $checkDate[$tgl] = 0;
        //     };
        // // dd($checkDate);
        // $result = [];
        // foreach ($namas as $nm) {
        //     foreach ($recordsProfitByName[$nm] as $tes => $val) {
        //         // dd($recordsProfitByName[$nm]);
        //         // foreach ($tanggals as $tgl) {
        //             // dd($tgl);
        //             // if ($tes != $tgl) {
        //             //     $recordsProfitByName[$nm][$tgl] = 0;
        //             // } 
        //             $result = array_merge($recordsProfitByName[$nm], $checkDate);
        //             dd($result);
                    
        //         // }
        //     }
        // }
        // dd($result);
        return view('dashboard', compact('datas','namas','tanggals','recordsProfitByName'));
    }

    public function export() {
        return Excel::download(new ExportLaporan, 'laporan_profit_loss.xlsx');
    }
}
