<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BarangSatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('barang_satuan')->insert([
            ['nama_satuan' => 'Buah'],
            ['nama_satuan' => 'Lusin'],
            ['nama_satuan' => 'Pak'],
            ['nama_satuan' => 'Centi'],
            ['nama_satuan' => 'Meter'],
            ['nama_satuan' => 'Kilo'],
            ['nama_satuan' => 'Gram'],
            ['nama_satuan' => 'Ons'],
            ['nama_satuan' => 'Liter'],
            ['nama_satuan' => 'Box'],
        ]);
    }
}
