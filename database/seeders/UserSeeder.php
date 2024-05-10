<?php

namespace Database\Seeders;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(UserRepository $userRepository): void
    {
            $userArray = [];
            $userArray['email'] = 'viethungw@gmail.com';
            $userArray['password'] = Hash::make('password');
            $userArray['name'] = 'Nguyễn Việt Hưng';
            $userArray['user_catalogue_id'] = 0;
            $userRepository->create($userArray);
    }

}
