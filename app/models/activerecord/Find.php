<?php

namespace Mervy\ActiveRecord\database\activerecord;

use Mervy\ActiveRecord\database\interfaces\ActiveRecordInterface;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordExecuteInterface;

class Find implements ActiveRecordExecuteInterface
{
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        echo 'FIND <br>';
        dd($activeRecordInterface->getAttributes(), 'v');
        echo '<hr>';

    }
}
