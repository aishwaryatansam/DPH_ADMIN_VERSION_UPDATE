<?php

use Illuminate\Database\Seeder;
use App\Models\Navigation;

class NavigationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $navigations = [

            ['name' => 'Government Order', 'slug_key' => 'government_order', 'order_no' => 1],
            ['name' => 'Circulars', 'slug_key' => 'circulars', 'order_no' => 2],
            ['name' => 'Instructions','slug_key' => 'instructions',  'order_no' => 3],
            ['name' => 'Acts/Rules', 'slug_key' => 'acts_rules', 'order_no' => 4],
            ['name' => 'Proceedings','slug_key' => 'proceedings',  'order_no' => 5],
            ['name' => 'Publications','slug_key' => 'publications',  'order_no' => 6],
            ['name' => 'Others','slug_key' => 'others',  'order_no' => 7],
            ['name' => 'News & Notifications','slug_key' => 'news_&_notifications',  'order_no' => 8],
            ['name' => 'Events','slug_key' => 'events',  'order_no' => 9],
            ['name' => 'Important Links','slug_key' => 'important_links',  'order_no' => 10],
            ['name' => 'RTI','slug_key' => 'rti',  'order_no' => 11],
            ['name' => 'Announcements','slug_key' => 'announcements',  'order_no' => 12],
            ['name' => 'Library','slug_key' => 'library',  'order_no' => 13],
        ];

        foreach ($navigations as $key => $navigation) {
            $navigation['status'] = _active();
            Navigation::create($navigation);
        }
    }
}
