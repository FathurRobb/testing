<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportLaporan implements Fromview
{
    public function view(): View
    {
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
            $recordsProfitByName[$record->nama][$record->tanggal] = $record->amount;
            if (!in_array($record->tanggal, $tanggals, true)) {
                array_push($tanggals, $record->tanggal);
            }
            if (!in_array($record->nama, $namas, true)) {
                array_push($namas, $record->nama);
            }
        }
        return view('laporan',[
            'datas'                 =>  $datas,
            'namas'                 =>  $namas,
            'tanggals'              =>  $tanggals,
            'recordsProfitByName'   =>  $recordsProfitByName
        ]);
    }
}
