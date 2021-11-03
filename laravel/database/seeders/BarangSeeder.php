<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 50; $i++){
            $num = str_pad($i, 2, '0', STR_PAD_LEFT);
            $ran = str_pad(rand(0,9999), 4, '0', STR_PAD_LEFT);
            DB::table('barang')->insert([
                'id_lokasi' => rand(1,25),
                'id_satuan' => rand(1,10),
                'kode_barang' => 'ABC'.$ran,
                'nama_barang' => 'Nama Barang '.$num,
                'stock' => rand(0,999),
            ]);
        }
    }
}
