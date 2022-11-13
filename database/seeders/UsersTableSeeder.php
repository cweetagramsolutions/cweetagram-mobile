<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $user = User::updateOrCreate([
                'name' => 'Chancel',
                'email' => 'chancel@cweetagram.co.za',
                'password' => bcrypt('p4ssw0rd!')
            ]);

        $user->assignRole(User::ADMIN_ROLE);

        $user = User::updateOrCreate([
                'name' => 'Mbali',
                'email' => 'dlomo.mbali@gmail.com',
                'password' => bcrypt('p4ssw0rd!')
            ]);

        $user->assignRole(User::ADMIN_ROLE);
    }
}
