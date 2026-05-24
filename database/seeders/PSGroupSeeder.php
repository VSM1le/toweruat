<?php

namespace Database\Seeders;

use App\Models\PsGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PSGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $psGroups = [
            [
                'ps_group' => 'RF',
                'ps_desc' => 'Rental Fee',
                'begin_date' => 1,
                'end_date' => 31,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'ps_group' => 'CV',
                'ps_desc' => 'Car Park Fee',
                'begin_date' => 16,
                'end_date' => 15,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'ps_group' => 'EC',
                'ps_desc' => 'Electric Fee',
                'begin_date' => 8,
                'end_date' => 7,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'ps_group' => 'OT',
                'ps_desc' => 'Other Fee',
                'begin_date' => 1,
                'end_date' => 31,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'ps_group' => 'WA',
                'ps_desc' => 'Water Fee',
                'begin_date' => 16,
                'end_date' => 15,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'ps_group' => 'CM',
                'ps_desc' => 'Other Fee',
                'begin_date' => 1,
                'end_date' => 31,
                'created_by' => 1,
                'updated_by' => 1
            ],
        ];
        foreach ($psGroups as $psGroup) {
            PsGroup::create($psGroup);
        }
    }
}
