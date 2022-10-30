<?php

namespace Naplanum\MVC\models\activerecord;

use Exception;
use Throwable;
use Naplanum\MVC\models\connection\Connection;
use Naplanum\MVC\interfaces\ActiveRecordInterface;
use Naplanum\MVC\interfaces\ActiveRecordExecuteInterface;


abstract class Delete implements ActiveRecordExecuteInterface
{
    public function __construct(private string $field, private string|int $value)
    {
    }

    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();

            $prepare = $connection->prepare($query);
            $prepare->execute([
                $this->field => $this->value
            ]);
            return $prepare->rowCount();
        } catch (Throwable $th) {
            formatException($th);
        }
    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {
        if ($activeRecordInterface->getAttributes()) {
            throw new Exception("Para deletar não precisa de atributos!");
        }

        $sql = "DELETE FROM {$activeRecordInterface->getTable()}";
        $sql .= " WHERE {$this->field} = :{$this->field}";
    }
}
