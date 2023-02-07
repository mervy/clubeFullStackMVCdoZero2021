<?php

namespace Mervy\ActiveRecord\database\activerecord;

use Mervy\ActiveRecord\database\connection\Connection;
use Throwable;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordInterface;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordExecuteInterface;

class FindBy  implements ActiveRecordExecuteInterface
{
    public function __construct(private string $field, private string|int $value, private string $fields = '*')
    {
    }

    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);

            $connection = Connection::connect();
            $prepare =  $connection->prepare($query);
            $prepare->execute([
                $this->field => $this->value
            ]);

            //Para exibir em Json
            header('Content-Type:application/json');
            return json_encode($prepare->fetch());

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
