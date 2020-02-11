<?php

use Illuminate\Database\Seeder;
use App\{VehiculosAnio, User};

class VehiculosAnioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
      $anios = [];
      foreach (range(1960, date('Y')) as $anio) {
        $anios[] = ['anio' => $anio];
      }
      User::where('role', 'admin')->first()->anios()->createMany($anios);
    }
}
