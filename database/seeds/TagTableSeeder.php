<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [

                ['name'=>'Accounts', 'slug_key' => 'accounts'],
                ['name'=>'Audit Party – 1', 'slug_key' => 'audit_party_1'],
                ['name'=>'Audit Party – 2', 'slug_key' => 'audit_party_2'],
                ['name'=>'Audit Party – 3', 'slug_key' => 'audit_party_3'],
                ['name'=>'Audit Party – 6', 'slug_key' => 'audit_party_6'],
                ['name'=>'Audit Party – 7', 'slug_key' => 'audit_party_7'], 
                ['name'=>'Bills', 'slug_key' => 'bills'],
                ['name'=>'Budget', 'slug_key' => 'budget'],
                ['name'=>'Cash', 'slug_key' => 'cash'],
                ['name'=>'DA', 'slug_key' => 'da'],
                ['name'=>'Drugs & Equipments', 'slug_key' => 'drugs_&_equipments'],
                ['name'=>'Despatch', 'slug_key' => 'despatch'],
                ['name'=>'Epidemics', 'slug_key' => 'epidemics'],
                ['name'=>'E1', 'slug_key' => 'e1'],
                ['name'=>'E2', 'slug_key' => 'e2'],
                ['name'=>'E3', 'slug_key' => 'e3'],
                ['name'=>'E4', 'slug_key' => 'e4'],
                ['name'=>'E5', 'slug_key' => 'e5'],
                ['name'=>'E6', 'slug_key' => 'e6'],
                ['name'=>'E7', 'slug_key' => 'e7'],
                ['name'=>'HEB', 'slug_key' => 'heb'],
                ['name'=>'Hygiene', 'slug_key' => 'hygiene'],
                ['name'=>'IDSP', 'slug_key' => 'idsp'],
                ['name'=>'IFHRMS', 'slug_key' => 'ifhrms'],
                ['name'=>'Immunization ', 'slug_key' => 'immunization'],
                ['name'=>'LAB', 'slug_key' => 'lab'],
                ['name'=>'Legal', 'slug_key' => 'legal'],
                ['name'=>'MCH-1', 'slug_key' => 'mch_1'],
                ['name'=>'MCH–2', 'slug_key' => 'mch_2'],
                ['name'=>'MP-1', 'slug_key' => 'mp_1'], 
                ['name'=>'MP-2', 'slug_key' => 'mp_2'],
                ['name'=>'MP-3', 'slug_key' => 'mp_3'],
                ['name'=>'MP-4', 'slug_key' => 'mp_4'],
                ['name'=>'MP-5', 'slug_key' => 'mp_5'],
                ['name'=>'Plan-1', 'slug_key' => 'plan_1'],
                ['name'=>'Plan-2', 'slug_key' => 'plan_2'],
                ['name'=>'Plan-3', 'slug_key' => 'plan_3'],
                ['name'=>'PHC- 3', 'slug_key' => 'phc_3'],
                ['name'=>'PHC- 5', 'slug_key' => 'phc_5'],
                ['name'=>'PHC- 6', 'slug_key' => 'phc_6'],
                ['name'=>'PHC- 7', 'slug_key' => 'phc_7'],
                ['name'=>'Record', 'slug_key' => 'record'],
                ['name'=>'SBHI-1', 'slug_key' => 'sbhi_1'],
                ['name'=>'SBHI-2', 'slug_key' => 'sbhi_2'],
                ['name'=>'Stationery', 'slug_key' => 'stationery'],
                ['name'=>'Tapal', 'slug_key' => 'tapal'],
                ['name'=>'Tobacco', 'slug_key' => 'tobacco'],
                ['name'=>'Training-I', 'slug_key' => 'training_I'],
                ['name'=>'Training-II', 'slug_key' => 'training-II'],
                ['name'=>'UHC', 'slug_key' => 'uhc'],
                ['name'=>'Urban-PHC ', 'slug_key' => 'urban_phc'],
                ['name'=>'VC-1', 'slug_key' => 'vc_1'],
                ['name'=>'VC-2', 'slug_key' => 'vc_2'],
                ['name'=>'VM', 'slug_key' => 'vm'],
                ['name'=>'RTI', 'slug_key' => 'rti'],
                ['name'=>'NCD', 'slug_key' => 'ncd'],
               
        ];

        foreach ($tags as $key => $tag) {
            $tag['status'] = _active();
            Tag::create($tag);
        }
    }
}
