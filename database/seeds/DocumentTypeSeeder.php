<?php

use App\models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document_types = [

            ['name' => 'Government Order', 'slug_key' => 'government_order', 'order_no' => 1],
            ['name' => 'Circulars/Instruction', 'slug_key' => 'circulars_instruction', 'order_no' => 2],
            ['name' => 'Proceedings','slug_key' => 'proceedings',  'order_no' => 3],
            ['name' => 'Acts/Rules', 'slug_key' => 'acts_rules', 'order_no' => 4],
            ['name' => 'Publications','slug_key' => 'publications',  'order_no' => 5],
            ['name' => 'Publications','slug_key' => 'publications',  'order_no' => 6],
            ['name' => 'RTI','slug_key' => 'rti',  'order_no' => 7],
            ['name' => 'Policy Note','slug_key' => 'policy_note',  'order_no' => 8],
            ['name' => 'Performance Budget','slug_key' => 'performance_budget',  'order_no' => 9],
            ['name' => 'Reports','slug_key' => 'reports',  'order_no' => 10],
            ['name' => 'Others','slug_key' => 'others',  'order_no' => 11],
            ['name' => 'Notification','slug_key' => 'notification',  'order_no' => 12],
            ['name' => 'Events','slug_key' => 'events',  'order_no' => 13],
            ['name' => 'Important Links','slug_key' => 'important_links',  'order_no' => 14],
        ];

        foreach ($document_types as $key => $document_type) {
            $document_type['status'] = _active();
            DocumentType::create($document_type);
        }
    }
}
