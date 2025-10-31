<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Block;

class BlockUniqueCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $blocks = Block::all();

        foreach ($blocks as $block){

        	$slugKey = Str::slug(str_replace(' ', '', $block->name));

        	$uniqueCode = $slugKey . str_pad($block->id, 5, '0', STR_PAD_LEFT);

        	$block->update(['unique_code' => $uniqueCode]);
        }
    }
}

