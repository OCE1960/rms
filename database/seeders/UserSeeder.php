<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user1 = User::updateOrCreate(
            [
                'email' => 'okekechristian1960@yahoo.com',
                'phone_no' => '07033792383',
            ],
            [
                'first_name' => 'Chukwuemeka',
                'last_name' => 'Okeke',
                'is_staff' => true,
                'password' => bcrypt('password')
            ]
        );

        $superAdmin = Role::where('key', 'super-admin')->firstOrFail();

        $user1->roles()->attach($superAdmin->id);

        $user2 = User::updateOrCreate(
            [
                'email' => 'registry@rms.com',
                'phone_no' => '07045692383',
            ],
            [
                'first_name' => 'RMS',
                'last_name' => 'registry',
                'is_staff' => true,
                'password' => bcrypt('password')
            ]
        );

        $registry = Role::where('key', 'registry')->firstOrFail();

        $user2->roles()->attach($registry->id);
    }
}
