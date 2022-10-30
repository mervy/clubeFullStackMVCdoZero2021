<?php

namespace Naplanum\MVC\models\activerecord;

use Throwable;
use Naplanum\MVC\models\connection\Connection;
use Naplanum\MVC\interfaces\ActiveRecordInterface;
use Naplanum\MVC\interfaces\ActiveRecordExecuteInterface;

class FindBy  implements ActiveRecordExecuteInterface
{
    public function __construct(
        private string $field,
        private string|int $value,
        private string $fields = '*'
    ) {
    }

    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();

            $prepare = $connection->prepare($query);
        } catch (Throwable $th) {
            formatException($th);
        }
    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {
        $sql = "SELECT {$this->fields} FROM {$activeRecordInterface->getTable()} WHERE {$this->field} = :{$this->field}";
        return $sql;
    }
}
