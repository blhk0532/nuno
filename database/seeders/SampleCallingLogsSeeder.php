<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SampleCallingLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 sample calling logs
        \Database\Factories\CallingLogFactory::new()->count(20)->create();
    }
}
