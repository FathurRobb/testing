<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MChartOfAccount;
use Carbon\Carbon;

class MChartOfAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MChartOfAccount::insert([
            [
                'id'            =>  1,
                'kode'          =>  401,
                'nama'          =>  'Gaji Karyawan',
                'kategori_id'   =>  1,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ],
            [
                'id'            =>  2,
                'kode'          =>  402,
                'nama'          =>  'Gaji Ketua MPR',
                'kategori_id'   =>  1,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ],
            [
                'id'            =>  3,
                'kode'          =>  403,
                'nama'          =>  'Profit Trading',
                'kategori_id'   =>  2,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ],
        ]);
    }
}
