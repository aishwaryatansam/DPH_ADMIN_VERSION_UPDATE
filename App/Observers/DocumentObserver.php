<?php

namespace App\Observers;

use App\Models\Document;

class DocumentObserver
{
    public function retrieved(Document $document)
    {
        $document->dated = dateOf($document->dated, 'm/d/Y');
    }
}
