<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::insert([
            'username'=>'Admin12',
            'email'=>'amirzanfikri5@gmail.com',
            'password'=>Hash::make('Admin@1234567890'),
            'nama'=>'admin',
            'email_verified'=>true,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
    }
}
