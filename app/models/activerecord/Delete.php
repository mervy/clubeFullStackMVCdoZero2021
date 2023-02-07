<?php

namespace Mervy\ActiveRecord\database\activerecord;

use Exception;
use Mervy\ActiveRecord\database\connection\Connection;
use Throwable;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordInterface;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordExecuteInterface;

class Delete implements ActiveRecordExecuteInterface
{

    public function __construct(private string $field, private string|int $value)
    {
    }
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        //DELETE FROM authors WHERE `authors`.`id` = 503"?
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
            throw new Exception('Para deletar não precisa passar atributos');
        }

        $sql = "DELETE FROM {$activeRecordInterface->getTable()}";
        $sql .= " WHERE {$this->field} = :{$this->field}";

        return $sql;
    }
}
