<?php

namespace App\Observers;

use App\Models\Block;
use App\Helpers\CustomHelper;


class BlockObserver
{
    public function created(Block $block)
    {

        $name = $block->name;
        $id = $block->id;
        $uniqueCode = generateUniqueCode($name, $id);
        $block->unique_code = $uniqueCode;
        $block->save();
 
    }
}
