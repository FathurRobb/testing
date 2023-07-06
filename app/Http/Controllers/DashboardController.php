<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportLaporan;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MKategori;

class DashboardController extends Controller
{
    public function index() {
        $datas = DB::table('m_kategoris')
                        ->join('m_chart_of_accounts', 'm_chart_of_accounts.kategori_id', '=', 'm_kategoris.id')
                        ->join('tb_transaksis', 'tb_transaksis.chart_of_account_id', '=', 'm_chart_of_accounts.id')
                        ->select('m_kategoris.nama', DB::raw("DATE_FORMAT(tb_transaksis.tanggal, '%Y-%m') AS tanggal"), DB::raw('SUM(tb_transaksis.credit)-SUM(tb_transaksis.debit) AS amount'))
                        ->groupBy('m_chart_of_accounts.kategori_id', DB::raw("DATE_FORMAT(tb_transaksis.tanggal, '%Y-%m')"))
                        ->get();
        $recordsProfitByName = [];
        $tanggals = [];
        $namas = [];
        foreach ($datas as $record) {
            $recordsProfitByName[$record->nama][$record->tanggal] = $record->amount ? $record->amount : "0";
            if (!in_array($record->tanggal, $tanggals, true)) {
                array_push($tanggals, $record->tanggal);
            }
            if (!in_array($record->nama, $namas, true)) {
                array_push($namas, $record->nama);
            }
        }
        usort($tanggals, function ($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        foreach ($namas as $nm) {
            foreach ($tanggals as $tgl) {
                if (array_key_exists($tgl, $recordsProfitByName[$nm])) {

                }else {
                    $recordsProfitByName[$nm][$tgl] = "0";
                }
                ksort($recordsProfitByName[$nm]);
            }
        }
        return view('dashboard', compact('datas','namas','tanggals','recordsProfitByName'));
    }

    public function export(Request $request) {
        return Excel::download(new ExportLaporan($request->date_from,$request->date_to), 'laporan_profit_loss.xlsx');
    }
}
