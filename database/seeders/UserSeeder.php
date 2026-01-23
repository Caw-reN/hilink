<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Link;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Hibrizi Tsaqif Rizky Gunawan',
            'username' => 'Cawren',
            'email' => 'hibrizitsaqif@gmail.com',
            'password' => bcrypt('ijjuuiue'),
            'bio' => 'Backend Developer | Laravel Enthusiast | Open Source Contributor',
            'bg_color' => '#1E293B',
        ]);

        Link::create([
            'user_id' => $user->id,
            'title' => 'Portofolio Website',
            'url' => 'https://cawren.my.id',
        ]);

        Link::create([
            'user_id' => $user->id,
            'title' => 'GitHub Profile',
            'url' => 'https://github.com/Caw-reN',
        ]);
    }
}
