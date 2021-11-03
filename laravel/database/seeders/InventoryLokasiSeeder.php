<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class InventoryLokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 25; $i++){
            $num = str_pad($i, 2, '0', STR_PAD_LEFT);
            $ran = str_pad(rand(1,99), 2, '0', STR_PAD_LEFT);
            DB::table('inventory_lokasi')->insert([
                'nama_lokasi' => 'L'.$num.'-R'.$ran.'A',
            ]);
        }
    }
}
