<?php

namespace Mervy\ActiveRecord\database\activerecord;

use Exception;
use Throwable;
use Mervy\ActiveRecord\database\connection\Connection;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordInterface;
use Mervy\ActiveRecord\database\interfaces\ActiveRecordExecuteInterface;

class FindAll implements ActiveRecordExecuteInterface
{
    public function __construct(
        private array $where = [],
        private string|int $orderby = '',
        private string|int $limit = '',
        private string|int $offset = '',
        private string $fields = '*'
    ) {
    }
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);

            $connection = Connection::connect();

            $prepare =  $connection->prepare($query);
            $prepare->execute($this->where);
         
            //Para exibir em Json
            header('Content-Type:application/json');
            return json_encode($prepare->fetchAll());

            //Senão usa só assim
           // return $prepare->fetchAll();

        } catch (Throwable $th) {
            formatException($th);
        }
    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {
        //Para mais índices tipo AND alterar a lógia do método
        if (count($this->where) > 1) {
            throw new Exception('No WHERE só pode passar um índice');
        }

        $where = array_keys($this->where);

        $sql = "SELECT {$this->fields} FROM {$activeRecordInterface->getTable()}";
        $sql .= (!$this->where) ? '' : " WHERE {$where[0]} = :{$where[0]}";
        $sql .= (!$this->orderby) ? '' : " ORDER BY {$this->orderby}";
        $sql .= (!$this->limit) ? '' : " LIMIT {$this->limit}";
        $sql .= ($this->offset == '') ? '' : " OFFSET {$this->offset}";

        return $sql;
    }
}
