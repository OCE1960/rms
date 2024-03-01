<?php

namespace Database\Seeders;

use App\Models\Enquirer;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnquirerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = new User;
        $user1->first_name = 'Samuel';
        $user1->last_name = 'Ajayi';
        $user1->email = 'md@asonic.com';
        $user1->is_result_enquirer = true;
        $user1->password = bcrypt('password');
        $user1->save();

        $enquirer1 = new Enquirer;
        $enquirer1->user_id = $user1->id;
        $enquirer1->organization_name = 'Asonic Associates Limited';
        $enquirer1->address = '68 Csacurina Close, Gaduwa, Abuja 900110, Federal Capital Territory, Nigeria';
        $enquirer1->save();

        $user2 = new User;
        $user2->first_name = 'Abiodun';
        $user2->last_name = 'Ezechi';
        $user2->email = 'md@koa.com';
        $user2->is_result_enquirer = true;
        $user2->password = bcrypt('password');
        $user2->save();

        $enquirer2 = new Enquirer;
        $enquirer2->user_id = $user2->id;
        $enquirer2->organization_name = 'KOA Consultants LTD';
        $enquirer2->address = '12A Morris Street, Abule Ijesha. Yaba, Lagos, Nigeria';
        $enquirer2->save();
    }
}
