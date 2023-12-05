<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'nama_operator'=>'Arif Pati Lubis',
                'nama_pengguna'=>'Arpalis',
                'lembaga'=>'Dirpp',
                'role'=>'1',
                'password'=>bcrypt('123456'),
                'status_id'=>'0'
            ],
            [
                'nama_operator'=>'Admin PDDIKTI',
                'nama_pengguna'=>'Pddikti',
                'lembaga'=>'Dirpp',
                'role'=>'1',
                'password'=>bcrypt('001003'),
                'status_id'=>'0'
            ],
            [
                'nama_operator'=>'Yolenta Panggabean',
                'nama_pengguna'=>'Yolenta',
                'lembaga'=>'Dirpp',
                'role'=>'2',
                'password'=>bcrypt('123456'),
                'status_id'=>'0'
            ]
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
