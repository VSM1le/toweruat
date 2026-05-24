<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $companies = [
            [
                'company_code' => '001',
                'com_abb' => 'NUAM',
                'com_building' => 'Nuam Tower',
                'com_building2' => null,
                'com_name_th' => 'บริษัท รสา ทาวเวอร์ จำกัด',
                'com_name_en' => 'Nuam Tower Co., Ltd.',
                'com_taxid' => '0105535006954',
                'com_address1' => '555 ถ.พหลโยธิน แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900',
                'com_address2' => null,
                'com_tel' => '02-9370000',
                'com_fax' => '029370001',
                'com_vat_rate1' => null,
                'com_startdate1' => null,
                'com_vat_rate2' => null,
                'com_startdate2' => null,
                'com_maxpark' => null,
                'com_m_maxpark' => null,
                'com_starttime' => null,
                'com_endtime' => null,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            // Add more entries as needed
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
