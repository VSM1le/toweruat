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
                'com_abb' => 'BTU',
                'com_building' => 'BTU Tower',
                'com_building2' => null,
                'com_name_th' => 'บริษัท บีทียู อโศก พร็อพเพอร์ตี้ จำกัด',
                'com_name_en' => 'BTU ASOK PROPERTY Co., Ltd.',
                'com_taxid' => '0105569078184',
                'com_address1' => '66 ถนนสุขุมวิท 21 (อโศก) แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร 10110',
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
