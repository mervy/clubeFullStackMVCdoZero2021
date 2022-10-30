<?php

namespace Naplanum\MVC\models\activerecord;

use Throwable;
use Naplanum\MVC\models\connection\Connection;
use Naplanum\MVC\interfaces\ActiveRecordInterface;
use Naplanum\MVC\interfaces\ActiveRecordExecuteInterface;

class Update implements ActiveRecordExecuteInterface
{
    public function __construct(private string $field, private string|int $value)
    {
    }

    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
