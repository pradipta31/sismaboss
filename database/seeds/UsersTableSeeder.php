<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'periode_id' => null,
                'name' => 'I Gede Pradipta Adi Nugraha',
                'username' => 'pradipta31',
                'nim' => '150030010',
                'email' => 'pradipta@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('123456'),
                'tgl_lahir' => date('Y-m-d'),
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Pratu Made Rambug, Batubulan, Gg. Bija V',
                'no_telp' => '087861863842',
                'status' => '1',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'I Made Adi Indrawan',
                'username' => 'adi',
                'nim' => '160030015',
                'email' => 'adi@gmail.com',
                'role' => 'ketua',
                'password' => bcrypt('123456'),
                'tgl_lahir' => date('Y-m-d'),
                'jenis_kelamin' => 'L',
                'alamat' => 'Denpasar',
                'no_telp' => '087861863842',
                'status' => '1',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'Gusti Ngurah Wisnu Grahawitara',
                'username' => 'wisnu',
                'nim' => '160030010',
                'email' => 'wisnu@gmail.com',
                'role' => 'wakil',
                'password' => bcrypt('123456'),
                'tgl_lahir' => date('Y-m-d'),
                'jenis_kelamin' => 'L',
                'alamat' => 'Denpasar',
                'no_telp' => '087861863842',
                'status' => '1',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'I Made Satya Sanjaya',
                'username' => 'satya',
                'nim' => '170030000',
                'email' => 'satya@gmail.com',
                'role' => 'wakil',
                'password' => bcrypt('123456'),
                'tgl_lahir' => date('Y-m-d'),
                'jenis_kelamin' => 'L',
                'alamat' => 'Denpasar',
                'no_telp' => '087861863842',
                'status' => '1',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'Ida Ayu Rara Sapnarianthi',
                'username' => 'rara',
                'nim' => '170030010',
                'email' => 'rara@gmail.com',
                'role' => 'sekretaris',
                'password' => bcrypt('123456'),
                'tgl_lahir' => date('Y-m-d'),
                'jenis_kelamin' => 'P',
                'alamat' => 'Denpasar',
                'no_telp' => '087861863842',
                'status' => '1',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'I Gusti Ayu Inten Indrayani',
                'username' => 'inten',
                'nim' => '170030060',
                'email' => 'inten@gmail.com',
                'role' => 'sekretaris',
                'password' => bcrypt('123456'),
                'tgl_lahir' => date('Y-m-d'),
                'jenis_kelamin' => 'P',
                'alamat' => 'Denpasar',
                'no_telp' => '087861863842',
                'status' => '1',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'Ni Putu Feby Citra Dewi',
                'username' => 'feby',
                'nim' => '170030020',
                'email' => 'feby@gmail.com',
                'role' => 'bendahara',
                'password' => bcrypt('123456'),
                'tgl_lahir' => date('Y-m-d'),
                'jenis_kelamin' => 'L',
                'alamat' => 'Denpasar',
                'no_telp' => '087861863842',
                'status' => '1',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'periode_id' => '1',
                'name' => 'Putu Eka Mahendra',
                'username' => 'azeka',
                'nim' => '150030020',
                'email' => 'azeka@gmail.com',
                'role' => 'bendahara',
                'password' => bcrypt('123456'),
                'tgl_lahir' => date('Y-m-d'),
                'jenis_kelamin' => 'L',
                'alamat' => 'Denpasar',
                'no_telp' => '087861863842',
                'status' => '1',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
        ]);
    }
}
