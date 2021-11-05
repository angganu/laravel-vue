<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class InventoryDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 25; $i++){
            $num = str_pad($i, 3, '0', STR_PAD_LEFT);
            $dep = str_pad(rand(1,999), 3, '0', STR_PAD_LEFT);
            $ran = str_pad(rand(1,99999), 5, '0', STR_PAD_LEFT);
            DB::table('inventory_detail')->insert([
                'id_inventory' => $i,
                'id_barang' => rand(1,50),
                'kuantiti' => rand(1,50),
                'keterangan' => '',
                'status' => 'Diterima',
            ]);
        }
    }
}
