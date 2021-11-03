<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 25; $i++){
            $ran = str_pad(rand(1,99999), 5, '0', STR_PAD_LEFT);
            DB::table('inventory')->insert([
                'id_employee'    => rand(1,25),
                'tgl_request' => date('Y-m-d H:i:s'),
                'kode_transaksi' => 'INV.'.$i.'-'.$ran,
            ]);
        }
    }
}
