<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MKategori;
use Carbon\Carbon;

class MKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MKategori::insert([
            [
                'id'            =>  1,
                'nama'          =>  'Salary',
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ],
            [
                'id'            =>  2,
                'nama'          =>  'Other Income',
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ],
        ]);
    }
}
