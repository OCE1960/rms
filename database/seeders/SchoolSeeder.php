<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::create([
            'full_name' => 'Moshood Abiola Polytechnic',
            'short_name' => 'ABEOKUTEPOLY',
            'address_street' => 'No 1 Abeokuta Road',
            'address_mailbox' => 'PMB 2210',
            'address_town' => 'Abeokuta',
            'state' => 'Ogun',
            'geo_zone' => 'South West',
            'type' => 'Polytechnic',
            'official_phone' => '07063331234',
            'official_email' => 'rector@mapoly.edu.ng',
            'official_website' => 'www.mapoly.edu.ng',
        ]);

        School::create([
            'full_name' => 'Niger State College of Education',
            'short_name' => 'MINNACOE',
            'address_street' => 'No 1 Minna Road',
            'address_mailbox' => 'PMB 123456',
            'address_town' => 'Minna',
            'state' => 'Niger',
            'geo_zone' => 'North Central',
            'type' => 'College',
            'official_phone' => '07063331234',
            'official_email' => 'provost@minnacoe.edu.ng',
            'official_website' => 'www.minnacoe.edu.ng',
        ]);

        School::create([
            'full_name' => 'Abubakar tafawa balewa university bauchi',
            'short_name' => 'ABU',
            'type' => 'University',
        ]);

        School::create([
            'full_name' => 'Bayero university kano',
            'short_name' => 'BAYERO',
            'type' => 'University',
        ]);

        School::create([
            'full_name' => 'Federal University Gashua Yobe State',
            'short_name' => 'FUG',
            'type' => 'University',
        ]);

        School::create([
            'full_name' => 'Federal University of Petroleum Resources Effurun',
            'short_name' => 'FUPRE',
            'type' => 'University',
        ]);

        School::create([
            'full_name' => 'Federal university of technology akure',
            'short_name' => 'FUTA',
            'type' => 'University',
        ]);

        School::create([
            'full_name' => 'Federal University of Technology Minna',
            'short_name' => 'FUTMINMA',
            'type' => 'University',
        ]);

        School::create([
            'full_name' => 'Federal University of Technology Owerri',
            'short_name' => 'FUTO',
            'type' => 'University',
        ]);

        School::create([
            'full_name' => 'Federal University Dutse Jigawa State',
            'short_name' => 'FUTJ',
            'type' => 'University',
        ]);

        School::create([
            'full_name' => 'Imo State University',
            'short_name' => 'IMSU',
            'type' => 'University',
        ]);

        School::create([
            'full_name' => 'River State University of Science and Technology',
            'short_name' => 'RSUST',
            'type' => 'University',
        ]);
    }
}
