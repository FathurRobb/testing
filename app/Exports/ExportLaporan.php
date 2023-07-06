<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\MKategori;

class ExportLaporan implements Fromview
{
    protected $date_from;
    protected $date_to;

    function __construct($date_from,$date_to) {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function view(): View
    {
        $d = MKategori::query()
                    ->join('m_chart_of_accounts', 'm_chart_of_accounts.kategori_id', '=', 'm_kategoris.id')
                    ->join('tb_transaksis', 'tb_transaksis.chart_of_account_id', '=', 'm_chart_of_accounts.id')
                    ->select('m_kategoris.nama', DB::raw("DATE_FORMAT(tb_transaksis.tanggal, '%Y-%m') AS tanggal"), DB::raw('SUM(tb_transaksis.credit)-SUM(tb_transaksis.debit) AS amount'))
                    ->groupBy('m_chart_of_accounts.kategori_id', DB::raw("DATE_FORMAT(tb_transaksis.tanggal, '%Y-%m')"))
                    ;
        if (!empty($this->date_from) && !empty($this->date_to)) {
           $d->whereBetween((DB::raw("DATE_FORMAT(tb_transaksis.tanggal, '%Y-%m')")),[$this->date_from,$this->date_to]);
        }
        $datas = $d->get();
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
        $t = MKategori::query()
                        ->join('m_chart_of_accounts', 'm_chart_of_accounts.kategori_id', '=', 'm_kategoris.id')
                        ->join('tb_transaksis', 'tb_transaksis.chart_of_account_id', '=', 'm_chart_of_accounts.id')
                        ->select('m_kategoris.type', DB::raw("DATE_FORMAT(tb_transaksis.tanggal, '%Y-%m') AS tanggal"), DB::raw('SUM(tb_transaksis.credit)-SUM(tb_transaksis.debit) AS amount'))
                        ->groupBy('m_kategoris.type', DB::raw("DATE_FORMAT(tb_transaksis.tanggal, '%Y-%m')"))
                        ;
        if (!empty($this->date_from) && !empty($this->date_to)) {
            $t->whereBetween((DB::raw("DATE_FORMAT(tb_transaksis.tanggal, '%Y-%m')")),[$this->date_from,$this->date_to]);
        }
        $totals = $t->get();
        $typeKategori = [];
        $types = ["0","1"];
        foreach ($totals as $total) {
            $typeKategori[$total->type][$total->tanggal] = $total->amount ? $total->amount : "0";
        }
        foreach ($types as $type) {
            foreach ($tanggals as $tgl) {
                if (array_key_exists($tgl, $typeKategori[$type])) {
    
                }else {
                    $typeKategori[$type][$tgl] = "0";
                }
                ksort($typeKategori[$type]);
            }
        }        
        $netIncomes = [];
        foreach ($tanggals as $tgl) {
            $netIncomes[$tgl] = $typeKategori[1][$tgl] - $typeKategori[0][$tgl];
        }
        return view('laporan',[
            'datas'                 =>  $datas,
            'namas'                 =>  $namas,
            'tanggals'              =>  $tanggals,
            'recordsProfitByName'   =>  $recordsProfitByName,
            'typeKategori'          =>  $typeKategori,
            'netIncomes'            =>  $netIncomes
        ]);
    }
}
