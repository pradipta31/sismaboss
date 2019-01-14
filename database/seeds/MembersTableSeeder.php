<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->insert([
            [
                'periode_id' => '1',
                'name' => 'Ketua UKM BOSS',
                'nim' => '160030015',
                'handphone' => '087861863842',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'Wakil UKM BOSS',
                'nim' => '160030010',
                'handphone' => '087861863842',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'I Made Satya Sanjaya',
                'nim' => '170030000',
                'handphone' => '087861863842',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'Ida Ayu Rara Sapnarianthi',
                'nim' => '170030010',
                'handphone' => '087861863842',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'Sekretaris UKM BOSS',
                'nim' => '170030060',
                'handphone' => '087861863842',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'Bendahara UKM BOSS',
                'nim' => '170030020',
                'handphone' => '087861863842',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'Putu Eka Mahendra',
                'nim' => '150030020',
                'handphone' => '087861863842',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
        ]);
    }
}
