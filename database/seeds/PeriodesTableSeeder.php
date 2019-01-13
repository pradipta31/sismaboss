<?php

use Illuminate\Database\Seeder;

class PeriodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('periodes')->insert([
            [
                'periode' => '2015/2016',
                'status' => 'aktif',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
        ]);
    }
}
