<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::query()->create([
            'name' => 'Main Company',
            'slug' => 'main',
            'email' => 'bittwin.dev@gmail.com',
        ]);
    }
}
