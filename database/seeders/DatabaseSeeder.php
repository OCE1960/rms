<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(EnquirerSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(StaffSeeder::class);
        $this->call(SemesterSeeder::class);
        $this->call(TranscriptRequestSeeder::class);
        $this->call(ResultVerificationRequestSeeder::class);
    }
}
