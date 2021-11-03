<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
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
            $dep = str_pad(rand(0,999), 3, '0', STR_PAD_LEFT);
            $ran = str_pad(rand(0,99999), 5, '0', STR_PAD_LEFT);
            DB::table('employee')->insert([
                'nik'    => $num.'.'.$dep.'.'.$ran,
                'nama' => 'Employee '.$num,
                'departemen'    => 'Departemen '.$dep
            ]);
        }
    }
}
