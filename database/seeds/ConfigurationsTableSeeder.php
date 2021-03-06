<?php

use Illuminate\Database\Seeder;
use App\User;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = User::where('role', 'admin')->first();

      $user->configuration()->create([]);
    }
}
