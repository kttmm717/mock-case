<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'テスト太郎',
            'email' => 'test@gmail.com',
            'email_verified_at' => Carbon::now(),
            'zipcode' => '959-0000',
            'address' => '新潟県新潟市中央区',
            'building' => 'マンション111',
            'password' => Hash::make('password')
        ];
        User::create($param);
    }
}
