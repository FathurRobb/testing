<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TbTransaksi;
use Carbon\Carbon;

class TbTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TbTransaksi::insert([
            [
                'id'                    =>  1,
                'chart_of_account_id'   =>  1,
                'tanggal'               =>  Carbon::parse('01-01-2022'),
                'deskripsi'             =>  'Gaji Di Persuhaan A',
                'debit'                 =>  0,
                'credit'                =>  5000000,
                'created_at'            =>  Carbon::now(),
                'updated_at'            =>  Carbon::now()
            ],
            [
                'id'                    =>  2,
                'chart_of_account_id'   =>  2,
                'tanggal'               =>  Carbon::parse('02-01-2022'),
                'deskripsi'             =>  'Gaji Ketum',
                'debit'                 =>  0,
                'credit'                =>  7000000,
                'created_at'            =>  Carbon::now(),
                'updated_at'            =>  Carbon::now()
            ],
        ]);
    }
}
