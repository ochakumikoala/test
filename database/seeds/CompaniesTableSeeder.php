<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "company_name"  => "companyA",
            ],
            [
                "company_name"  => "companyB",
            ],

        ];
        DB::table('companies')->insert($data);

    }
}
